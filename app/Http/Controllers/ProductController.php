<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Group;
use App\User;
use Auth;
use App\Model\Backend\Supplier;
use App\Model\Backend\Product\ProductVariation;
use App\Model\Backend\Product\ProductGradeType;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use DB;
use Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {   
       // return Product::where('status',1)->whereNull('deleted_at')->count();
        /*$data['products'] = Product::where('status',1)->whereNull('deleted_at')
                        ->orderByRaw('LENGTH(custom_code)', 'ASC')
                        ->orderBy('custom_code', 'ASC')->get();*/
        //$data['products'] = Product::where('status',1)->whereNull('deleted_at')->OrderBy('id','ASC')->get();
        /*return view('backend.products.view',$data);*/
        
       $data['categories']  = Category::all();
       $data['brands']      = Brand::all();
       $data['supplieres']  = Supplier::all();
       $data['groupes']     = Group::all();

        $query = Product::query();

        if($request->group_id)
        {
            $data['group_id'] = $request->group_id;
            $query = $query->where('group_id',$request->group_id);
        }
        
        if($request->brand_id)
        {
            $data['brand_id'] = $request->brand_id;
            $query = $query->where('brand_id',$request->brand_id);
        }

        if($request->supplier_id)
        {
            $data['supplier_id'] = $request->supplier_id;
            $query = $query->where('supplier_id',$request->supplier_id);
        }

        if($request->category_id)
        {
            $data['category_id'] = $request->category_id;
            $query = $query->where('category_id',$request->category_id);
        }


        $data['products'] =  $query->orderByRaw('LENGTH(custom_code)', 'ASC')
                             ->orderBy('custom_code', 'ASC')
                             ->get();
    

         return view('backend.products.view',$data);
    }

    public function create()
    {
        /* $product = ProductVariation::where('supplier_id',NULL)->delete();
         $product = Product::where('supplier_id',NULL)->delete();
        return "deleted";*/
     


        //$data['suppliers'] = User::where('role',3)->get();
        $data['suppliers'] = Supplier::get();
        $data['customers'] = User::where('role',4)->get();
        $data['brands'] = Brand::all();
        $data['categories'] = Category::all();
        $data['units'] = Unit::all();
        $data['grades'] = ProductGradeType::all();
        $data['groupes']   = Group::all();
        return view('backend.products.add',$data);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'purchase_unit' => 'required',
            'supplier_id' => 'required',
        ]);

        DB::beginTransaction();
        try 
        {
            $data = new Product;

                $checkproductidcount = Product::orderBy('id','DESC')->count();
                $checkproductid = Product::orderBy('id','DESC')->first();

                if($checkproductidcount>0)
                {
                    $data->product_uid = $checkproductid->productuid+1;
                }
                else{
                    $data->product_uid  = '2000001';
                }

            $data->company_uid           = companyId_HH();
            $data->user_id               = Auth::user()->id;

            $data->supplier_id           = $request->supplier_id;
            $data->grade_type_id         = $request->grade_type_id;
            $data->name                  = $request->name;
            $data->purchase_price        = $request->purchase_price;
            $data->sale_price            = $request->sale_price;
            $data->whole_sale_price      = $request->whole_sale_price;
            $data->mrp_price             = $request->mrp_price;

            $data->online_sell_price     = $request->online_sell_price;
            $data->online_discount_price  = 00;
            $data->category_id           = $request->category_id;
            $data->group_id              = $request->group_id;
            $data->brand_id              = $request->brand_id;
            $data->purchase_unit_id       = $request->purchase_unit;
            $data->sale_unit_id           = $request->purchase_unit;
            $data->low_sell_qty             = $request->low_sale_qty;
            $data->low_alert_qty            = $request->low_alert_qty;

            $data->warranty_period_type     = $request->warrantity_period_type;
            $data->warranty_period          = $request->warranty_period;
            $data->warranty_value           =  daysMonthsYearsConverters_HH($request->warrantity_period_type,$request->warranty_period);

            $data->guarantee_period_type    = $request->guarantee_period_type;
            $data->guarantee_period         = $request->guarantee_period;
            $data->guarantee_value          =  daysMonthsYearsConverters_HH($request->guarantee_period_type,$request->guarantee_period);

            $data->expiry_period_type       = $request->expiry_period_type;
            $data->expiry_period            = $request->expiry_period;

            $data->expiry_value             =  daysMonthsYearsConverters_HH($request->expiry_period_type,$request->expiry_period);

            $data->sale_discount_type       = $request->discount_type;
            $data->sale_discount_value      = $request->discount_value;
            $data->company_code             = $request->company_code;
            $data->custom_code              = $request->custom_code;
            $data->sale_discount_amount     = discountCalculate_HH($request->discount_type,$request->sale_price, $request->discount_value); //$types="fixed",$calculate_with = 0, $calculate_by = 0


            $data->initial_stock            = $request->initial_stock;
            $data->description              = $request->description;

            $image = $request->file('default_photo');
            if($image){
                $uniqname = uniqid();
                $ext = strtolower($image->getClientOriginalExtension());
                $filepath = 'public/uploaded/products/';
                $imagename = $filepath.$uniqname.'.'.$ext;
                $image->move($filepath,$imagename);
                $data['default_photo'] = $imagename;

            }

            /* not understanding*/

            $data->product_sku           = 1;
            $data->bussiness_type_id     = businessTypeId_HH();
            $data->brunch_id             = 1;
            $data->is_return             = 1;
            $data->tax_type              = 1;
            $data->tax                   = 1;
            $data->barcode_type          = 1;
            $data->status          = 1;

            /* not understanding*/

            $data->save();

            /** product Variation table */
            $this->insertProductVariationData($data);

            DB::commit();

            $notification = array(
                'message' => 'Product Inserted successfully !!',
                'alert-type' => 'success',
            );
            return redirect()->route('product.index')->with($notification);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            if($e->getMessage())
            {
                $message = "Something went wrong! Please Try again";
            }
            return Redirect()->back()
                ->with('error',$e->getMessage());
        }
    }



    public function insertProductVariationData($data)
    { 
        $proVari = new ProductVariation();
        $proVari->business_type_id          = 1;
        $proVari->product_id                = $data->id;
        $proVari->grade_type_id             = $data->grade_type_id;
        $proVari->supplier_id               = $data->supplier_id;
        $proVari->default_purchase_price    = $data->purchase_price;
        $proVari->whole_sale_price          = $data->whole_sale_price;
        $proVari->unit_selling_price_inc_tax = $data->sale_price;
        $proVari->unit_selling_price_exc_tax = $data->sale_price;
        $proVari->default_selling_price      = $data->sale_price;

        $proVari->default_purchase_unit_id  = $data->purchase_unit_id;
        $proVari->default_sale_unit_id      = $data->purchase_unit_id;

        $proVari->mrp_price                 = $data->mrp_price;

        $proVari->alert_quantity            = $data->low_alert_qty;

        $proVari->company_code              = $data->company_code;
        $proVari->custom_code               = $data->custom_code;

        $proVari->save();
        return $proVari;

        $proVari->default_purchase_price = $request->purchase_price;
        $proVari->default_selling_price  = $request->sale_price;
        $proVari->whole_sale_price       = $request->whole_sale_price;
    }

   

    public function show($id)
    {
        $data['product'] = Product::findOrfail($id);
        return view('backend.products.show',$data);
    }


    public function edit($id)
    {
        $data['product'] = Product::find($id);
        //$data['suppliers'] = User::where('role',3)->get();
        $data['suppliers'] = Supplier::get();
        $data['customers'] = User::where('role',4)->get();
        $data['brands'] = Brand::all();
        $data['categories'] = Category::all();
        $data['units'] = Unit::all();
        $data['grades'] = ProductGradeType::all();
        $data['groupes']     = Group::all();
        return view('backend.products.edit',$data);
    }


    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'purchase_unit' => 'required',
            'supplier_id' => 'required',
        ]);

        DB::beginTransaction();
        try 
        {
            $data = Product::find($id);

            $checkproductidcount = Product::orderBy('id','DESC')->count();
            $checkproductid = Product::orderBy('id','DESC')->first();

            if($checkproductidcount>0)
            {
                $data->product_uid = $checkproductid->productuid+1;
            }
            else{
                $data->product_uid  = '2000001';
            }

            //===================================================================
            $data->company_uid           = companyId_HH();
            $data->user_id               = Auth::user()->id;

            $data->supplier_id           = $request->supplier_id;
            $data->name                  = $request->name;
            $data->grade_type_id         = $request->grade_type_id;
            $data->purchase_price        = $request->purchase_price;
            $data->sale_price            = $request->sale_price;
            $data->whole_sale_price      = $request->whole_sale_price;
            $data->mrp_price             = $request->mrp_price;

            $data->online_sell_price     = $request->online_sell_price;
            $data->online_discount_price  = 00;
            $data->category_id           = $request->category_id;
            $data->group_id              = $request->group_id;
            $data->brand_id              = $request->brand_id;
            $data->purchase_unit_id         = $request->purchase_unit;
            $data->sale_unit_id             = $request->purchase_unit;
            $data->low_sell_qty          = $request->low_sale_qty;
            $data->low_alert_qty         = $request->low_alert_qty;

            $data->warranty_period_type     = $request->warrantity_period_type;
            $data->warranty_period          = $request->warranty_period;
            $data->warranty_value           =  daysMonthsYearsConverters_HH($request->warrantity_period_type,$request->warranty_period);

            $data->guarantee_period_type    = $request->guarantee_period_type;
            $data->guarantee_period         = $request->guarantee_period;
            $data->guarantee_value          =  daysMonthsYearsConverters_HH($request->guarantee_period_type,$request->guarantee_period);

            $data->expiry_period_type       = $request->expiry_period_type;
            $data->expiry_period            = $request->expiry_period;

            $data->expiry_value             =  daysMonthsYearsConverters_HH($request->expiry_period_type,$request->expiry_period);

            $data->sale_discount_type       = $request->discount_type;
            $data->sale_discount_value      = $request->discount_value;
            $data->sale_discount_amount     = discountCalculate_HH($request->discount_type,$request->sale_price, $request->discount_value); //$types="fixed",$calculate_with = 0, $calculate_by = 0

            $data->initial_stock            = $request->initial_stock;
            $data->description              = $request->description;

            
            $data->company_code              = $request->company_code;
            $data->custom_code               = $request->custom_code;


            $image = $request->file('default_photo');
            if($image){
                $uniqname = uniqid();
                $ext = strtolower($image->getClientOriginalExtension());
                $filepath = 'public/uploaded/products/';
                $imagename = $filepath.$uniqname.'.'.$ext;
                @unlink($data->default_photo);
                $image->move($filepath,$imagename);
                $data['default_photo'] = $imagename;

            }

            /* not understanding*/
            $data->product_sku           = 1;
            $data->bussiness_type_id     = businessTypeId_HH();
            $data->brunch_id             = 1;
            $data->is_return             = 1;
            $data->tax_type              = 1;
            $data->tax                   = 1;
            $data->barcode_type          = 1;
            $data->status          = 1;
            /* not understanding*/
            $data->save();

            $this->updateProductVariationData($data);

            DB::commit();

            $notification = array(
                'message' => 'Product updated successfully !!',
                'alert-type' => 'success',
            );
            return redirect()->route('product.index')->with($notification);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            if($e->getMessage())
            {
                $message = "Something went wrong! Please Try again";
            }
            return Redirect()->back()
                ->with('error',$e->getMessage());
        }
    }

    public function updateProductVariationData($data)
    {
        $proVari = ProductVariation::where('product_id',$data->id)->whereNull('deleted_at')->first();
        $proVari->business_type_id              = 1;
        $proVari->product_id                    = $data->id;
        $proVari->grade_type_id                 = $data->grade_type_id;
        $proVari->supplier_id                   = $data->supplier_id;
        $proVari->default_purchase_price        = $data->purchase_price;
        $proVari->whole_sale_price              = $data->whole_sale_price;
        $proVari->unit_selling_price_inc_tax    = $data->sale_price;
        $proVari->unit_selling_price_exc_tax    = $data->sale_price;
        $proVari->default_selling_price         = $data->sale_price;
        $proVari->default_purchase_unit_id      = $data->purchase_unit_id;
        $proVari->default_sale_unit_id          = $data->purchase_unit_id;
        $proVari->mrp_price                     = $data->mrp_price;
        $proVari->alert_quantity                = $data->low_alert_qty;

        
        $proVari->company_code                  = $data->company_code;
        $proVari->custom_code                   = $data->custom_code;
        $proVari->save();
        return $proVari;

        $proVari->default_purchase_price        = $request->purchase_price;
        $proVari->default_selling_price         = $request->sale_price;
        $proVari->whole_sale_price              = $request->whole_sale_price;
    }




    public function destroy($id)
    {
        $product = Product::findOrfail($id);
        if($product->productVariations)
        {
            $product->productVariations->deleted_at = 2;
            $product->productVariations->deleted_at = date('Y-m-d h:i:s');
            $product->productVariations->save();
        }
        $product->status = 2;
        $product->deleted_at = date('Y-m-d h:i:s');
        $product->save();

        $notification = array(
                'message' => 'Product Deleted Successfully!',
                'alert-type' => 'success'
        );

        return redirect()->route('product.index')->with($notification);

    }



    public function excel_file_uploadable_modal(Request $request)
    {
        return view('backend.products.uploadable_modal_for_excel_file'); 
    }

    public function excel_file_upload(Request $request)
    {
        if($request->hasFile('file'))
        {
            $result = Excel::import(new ProductImport,request()->file('file'));
            if($result)
            {
                $notification = array(
                'message' => 'Product upload successfully !!',
                'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            }
            else{
                $notification = array(
                'message' => 'Product file upload error !!',
                'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            }
        }
        $notification = array(
            'message' => 'Select  a file for Upload!!',
            'alert-type' => 'error',
        );
        return redirect()->back()->with($notification);	
    }


    public function product_list_export(Request $request)
    {
        ini_set('memory_limit','2048M');
        ini_set('max_execution_time', 300); //6 minutes
        $input = $request->all();
         $allProductId = [];
         if($request->product_id == null)
         {
            $data['products'] = Product::where('status',1)->whereNull('deleted_at')->get();
         }
         else{
            if($input['product_id'] != ''){
                foreach ($input['product_id'] as $key => $value) {
                    array_push($allProductId,$input['product_id'][$key]);
                }
            }
            ini_set('memory_limit','2048M');
            $data['products'] = Product::whereIn('id',$allProductId)->get();
        }
        $pdf = PDF::loadView('backend.products.export_product_list',$data);
        return $pdf->download('Product List.pdf');
    }


    public function updatePrice($id)
    {
        $data['product'] = Product::findOrfail($id);
        return view('backend.products.update_price',$data);
    }

    public function updatePriceStore(Request $request , $id)
    {
        // Start transaction!
        DB::beginTransaction();
        try 
        {
            $product = Product::findOrfail($id);
            $product->purchase_price    = $request->purchase_price;
            $product->sale_price        = $request->sale_price;
            $product->whole_sale_price  = $request->whole_sale_price;
            $product->mrp_price         = $request->mrp_price;
            $product->online_sell_price = $request->online_sell_price;
            $product->save();

            $proVar = ProductVariation::where('product_id',$id)->whereNull('deleted_at')->first();
            $proVar->default_purchase_price = $request->purchase_price;
            $proVar->default_selling_price  = $request->sale_price;
            $proVar->whole_sale_price       = $request->whole_sale_price;
            $proVar->save();
            DB::commit();
            $notification = array(
                'message' => 'Product Price Updated Successfully!',
                'alert-type' => 'success'
            );
            return redirect()->route('product.index')->with($notification);           
        }
        catch(\Exception $e)
        {
            DB::rollback();
            if($e->getMessage())
            {
                $message = "Something went wrong! Please Try again";
            }
            return Redirect()->back()
                ->with('error',$e->getMessage());
        }
    }
    
    
    
    
    
        public function supplierproduct(Request $request,$id)
        {

            $data['suppliers'] = Supplier::get();
            $data['customers'] = User::where('role',4)->get();
            $data['brands'] = Brand::all();
            $data['categories'] = Category::all();
            $data['units'] = Unit::all();
            $data['grades'] = ProductGradeType::all();
            $data['groupes']   = Group::all();
            
            
            
            $data['supplierdetail'] = Supplier::find($id);
            $data['products'] = Product::where('supplier_id',$id)->get();

            return view('backend.products.supplierproduct',$data);
        }




        public function supplierupdateproduct(Request $request)
        {
                    $input = $request->all();

                    DB::beginTransaction();
                    try 
                    {

                    if($input['productid'] != ''){
                        foreach ($input['productid'] as $key => $value) {
                     
                       
                            $data = Product::find($input['productid'][$key]);

                            $data->supplier_id           = $input['supplier_id'][$key];
                            $data->name                  = $input['name'][$key];
                            /*$data->grade_type_id         = $input['grade_type_id'][$key];*/
                            $data->purchase_price        = $input['purchase_price'][$key];
                            $data->sale_price            = $input['sale_price'][$key];
                            $data->whole_sale_price      = $input['whole_sale_price'][$key];
                            $data->mrp_price             = $input['mrp_price'][$key];
                            $data->online_sell_price     = $input['online_sell_price'][$key];

                            $data->category_id           = $input['category_id'][$key];
                            $data->group_id              = $input['group_id'][$key];
                            $data->brand_id              = $input['brand_id'][$key];
                           /* $data->purchase_unit_id      = $input['purchase_unit'][$key];
                            $data->sale_unit_id          = $input['purchase_unit'][$key];*/
                        
                            $data->company_code          = $input['company_code'][$key];
                            $data->custom_code           = $input['custom_code'][$key];
                            $data->description           = $input['description'][$key];
                            
                            $data->warranty_period_type  = $input['warrantity_period_type'][$key];
                            $data->warranty_period       = $input['warranty_period'][$key];
                            $data->warranty_value        =  daysMonthsYearsConverters_HH($input['warrantity_period_type'][$key],$input['warranty_period'][$key]);
                            
                            $data->low_sell_qty          = $input['low_sale_qty'][$key];
                            $data->low_alert_qty         = $input['low_alert_qty'][$key];

                            $data->save();

                            $this->updateProductVariationData($data);

                       
                        }

                    }


                    DB::commit();

                    $notification = array(
                        'message' => 'Product updated successfully !!',
                        'alert-type' => 'success',
                    );
                    return redirect()->route('supplier.index')->with($notification);

 
                    }
                    catch(\Exception $e)
                    {
                        DB::rollback();
                        if($e->getMessage())
                        {
                            $message = "Something went wrong! Please Try again";
                        }
                        return Redirect()->back()
                            ->with('error',$e->getMessage());
                    }
    }
    
    
    
    
    
    
    
    public function multipleproduct($supplier_id)
    {

        $data['suppliers'] = Supplier::get();
        $data['customers'] = User::where('role',4)->get();
        $data['brands'] = Brand::all();
        $data['categories'] = Category::all();
        $data['units'] = Unit::all();
        $data['grades'] = ProductGradeType::all();
        $data['groupes']   = Group::all();
        
        $data['findsupplierascode'] = Supplier::find($supplier_id)->code_sequence;
        
        $data['supplier_id'] = $supplier_id;
        return view('backend.products.multipleproduct',$data);
    }
    
    
    

    public function multipleproductstore(Request $request)
    {



        $input = $request->all();


        if($input['supplier_id']!='')
        {
            foreach($input['supplier_id'] as $key => $value) {
                
                DB::beginTransaction();
                try 
                {
                    $data = new Product;

                        $checkproductidcount = Product::orderBy('id','DESC')->count();
                        $checkproductid = Product::orderBy('id','DESC')->first();

                        if($checkproductidcount>0)
                        {
                            $data->product_uid = $checkproductid->productuid+1;
                        }
                        else{
                            $data->product_uid  = '2000001';
                        }

                    $data->company_uid           = companyId_HH();
                    $data->user_id               = Auth::user()->id;

                    $data->supplier_id           = $input['supplier_id'][$key];
                    $data->grade_type_id         = $input['grade_type_id'][$key];
                    $data->name                  = $input['name'][$key];
                    $data->purchase_price        = $input['purchase_price'][$key];
                    $data->sale_price            = $input['sale_price'][$key];
                    $data->whole_sale_price      = $input['whole_sale_price'][$key];
                    $data->mrp_price             = $input['mrp_price'][$key];

                    $data->online_sell_price     = $input['online_sell_price'][$key];
                    $data->online_discount_price  = 00;
                    $data->category_id           = $input['category_id'][$key];
                    $data->group_id              = $input['group_id'][$key];
                    $data->brand_id              = $input['brand_id'][$key];
                    $data->purchase_unit_id      = $input['purchase_unit'][$key];
                    $data->sale_unit_id          = $input['purchase_unit'][$key];
                    $data->low_sell_qty          = 0;
                    $data->low_alert_qty         = $input['low_alert_qty'][$key];

                    $data->warranty_period_type  = $input['warrantity_period_type'][$key];
                    $data->warranty_period          = $input['warranty_period'][$key];
                    $data->warranty_value           =  daysMonthsYearsConverters_HH($input['warrantity_period_type'][$key],$input['warranty_period'][$key]);

                    $data->guarantee_period_type    = $input['guarantee_period_type'][$key];
                    $data->guarantee_period         = $input['guarantee_period'][$key];
                    $data->guarantee_value          =  daysMonthsYearsConverters_HH($input['guarantee_period_type'][$key],$input['guarantee_period'][$key]);

                    $data->expiry_period_type       = $input['expiry_period_type'][$key];
                    $data->expiry_period            = $input['expiry_period'][$key];

                    $data->expiry_value             =  daysMonthsYearsConverters_HH($input['expiry_period_type'][$key],$input['expiry_period'][$key]);

            
                    $data->company_code             = $input['company_code'][$key];
                    $data->custom_code              = $input['custom_code'][$key];
               
                    $data->description              = $input['description'][$key];

                     
                  
                    $data->product_sku           = 1;
                    $data->bussiness_type_id     = businessTypeId_HH();
                    $data->brunch_id             = 1;
                    $data->is_return             = 1;
                    $data->tax_type              = 1;
                    $data->tax                   = 1;
                    $data->barcode_type          = 1;
                    $data->status          = 1;

                    /* not understanding*/

                    $data->save();

                    /** product Variation table */
                    $this->insertProductVariationData($data);

                    DB::commit();
                   
                }
                catch(\Exception $e)
                {
                    DB::rollback();
                    if($e->getMessage())
                    {
                        $message = "Something went wrong! Please Try again";
                    }
                    return Redirect()->back()
                        ->with('error',$e->getMessage());
                }

            }
        }
         $notification = array(
            'message' => 'Product Inserted successfully !!',
            'alert-type' => 'success',
        );
        return redirect()->route('product.index')->with($notification);


    }



    
    
    
    
    
    


}
