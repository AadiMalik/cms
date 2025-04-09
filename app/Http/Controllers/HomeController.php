<?php

namespace App\Http\Controllers;

use App\Services\Concrete\CustomerService;
use App\Services\Concrete\JobTaskService;
use App\Services\Concrete\NotificationService;
use App\Services\Concrete\ProductService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $job_task_service;
    protected $product_service;
    protected $notification_service;
    protected $customer_service;
    public function __construct(
        JobTaskService $job_task_service,
        NotificationService $notification_service,
        ProductService $product_service,
        CustomerService $customer_service
    ) {
        $this->middleware('auth');
        $this->job_task_service = $job_task_service;
        $this->notification_service = $notification_service;
        $this->product_service = $product_service;
        $this->customer_service = $customer_service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            DB::beginTransaction();
            if (getRoleName() == config('enum.supplier')) {
                $job_tasks = $this->job_task_service->getCurrentDeliveryBySupplierId(Auth::user()->supplier_id);
                // dd($job_tasks);
                foreach ($job_tasks as $item) {
                    $date = Carbon::parse($item->delivery_date);
                    $obj = [
                        "title" => 'Delivery Reminder',
                        "user_id" => Auth::user()->id,
                        "message" => $item->job_task_no . ' delivery date: ' . $date->format('Y-m-d H:i A'),
                        "play_sound" => 1
                    ];
                    $this->notification_service->save($obj);
                }
                return redirect('job-task');
            }

            if (getRoleName() == config('enum.superAdmin')) {
                $mol_product = $this->product_service->getAllMolProduct();
                // dd($job_tasks);
                foreach ($mol_product as $item) {
                    $obj = [
                        "title" => 'Product Low Stock',
                        "user_id" => Auth::user()->id,
                        "message" => $item->name . ' quantity is low. remening stock is ' . $item->total_quantity ?? 0,
                        "play_sound" => 1
                    ];
                    $this->notification_service->save($obj);
                }

                // Anniversary && Birthday
                $date = Carbon::now()->format('d M Y');

                $anniversary_customers = $this->customer_service->getAllAnniversaryCustomer();
                foreach ($anniversary_customers as $item) {
                    $obj = [
                        "title" => 'Wishing to Customer',
                        "user_id" => Auth::user()->id,
                        "message" => 'Say Happy Anniversary to ' . $item->name . '. Anniversary date is ' . $date,
                        "play_sound" => 0
                    ];
                    $this->notification_service->save($obj);
                }

                $dob_customers = $this->customer_service->getAllBirthdayCustomer();
                foreach ($dob_customers as $item) {
                    $obj = [
                        "title" => 'Wishing to Customer',
                        "user_id" => Auth::user()->id,
                        "message" => 'Say Happy Birthday to ' . $item->name . '. Date of birth is ' . $date,
                        "play_sound" => 0
                    ];
                    $this->notification_service->save($obj);
                }
            }

            $result = DB::select('CALL GetSalesAndCustomerSummary()');
            $data = $result[0];
            $monthly_sale = DB::select("SELECT 
            DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -seq.seq MONTH), '%M') AS month_name,
            DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -seq.seq MONTH), '%Y') AS sale_year,
            COALESCE(SUM(s.total), 0) AS total_sales
        FROM (
            SELECT 0 AS seq UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
            UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6
            UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
            UNION ALL SELECT 10 UNION ALL SELECT 11
        ) AS seq
        LEFT JOIN sales s ON DATE_FORMAT(s.sale_date, '%Y-%m') = DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -seq.seq MONTH), '%Y-%m')
        LEFT JOIN sale_details sd ON sd.sale_id = s.id
        GROUP BY seq.seq
        ORDER BY seq.seq DESC
    ");
            $highest_products = DB::select('SELECT 
            p.id AS product_id,
            p.name AS product_name,
            SUM(sd.total_amount) AS total_sales
         FROM sale_details sd
         JOIN sales s ON sd.sale_id = s.id
         JOIN products p ON sd.product_id = p.id
         WHERE s.is_deleted = 0
         GROUP BY p.id,p.name
         ORDER BY total_sales DESC
         LIMIT 5');

            $month = [];
            $sales = [];
            foreach ($monthly_sale as $item) {
                $month[] = (string)$item->month_name;
                $sales[] = (int)$item->total_sales;
            }
            $month = json_encode($month);
            $sales = json_encode($sales);
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            throw $e;
        }
        return view('home', compact('data', 'month', 'sales', 'highest_products'));
    }
}
