<?php

namespace App\Imports;

use App\Model\Backend\Product\Product;
use App\Model\Backend\Product\ProductVariation;
use Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
//class ProductImport implements ToModel , WithStartRow
class ProductImport implements ToCollection , WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $product = Product::latest()->first();
            $data = new Product([
                'bussiness_type_id'     => 1,
                'user_id'               => Auth::user()->id,
                'company_uid'           => companyId_HH(),
                'company_code'          => $row[0],   
                'custom_code'           => $row[1],   
                'name'                  => $row[2],
                'bar_code'              => $row[3],
                'supplier_id'           => $row[4],
                'purchase_price'        => $row[5],   
                'whole_sale_price'      => $row[6],   
                'sale_price'            => $row[7],   
                'mrp_price'             => $row[8],   
                'online_sell_price'     => $row[9],   
                'category_id'           => $row[10],   
                'brand_id'              => $row[11],   
                'purchase_unit_id'      => $row[12],   
                'sale_unit_id'          => $row[12],   
                'low_alert_qty'         => $row[13],   
                'expiry_period'         => $row[14],   
                'expiry_period_type'    => $row[14] == 1 ? 'months' : NULL,   
                'expiry_value'          => $row[14] == 1 ? $row[15] : NULL,   
                'product_uid'           => $product?$product->product_uid + 1 :NULL,
                'grade_type_id'         => $row[16], 
                //'sku'                   => $row[1],
                //'online_discount_price' => $row[10],   
                //'warranty_period' => $row[3],   
                //'warranty_period_type' => $row[3],   
                //'warranty_value' => $row[3],   
                //'guarantee_period' => $row[3],   
                //'guarantee_period_type' => $row[3],   
                //'guarantee_value' => $row[3],      
            ]); 
            $data->save();

            $pv = new ProductVariation();
            $pv->business_type_id                           = 1;
            $pv->product_id                                 = $data->id;
            $pv->grade_type_id                              = $data->grade_type_id;
            $pv->company_code                               = $data->company_code;
            $pv->custom_code                                = $data->custom_code;
            $pv->sub_sku                                    = $data->sku . $data->id;
            $pv->expiry_period                              = $data->expiry_period;
            $pv->expiry_period_type                         = $data->expiry_period_type;
            $pv->expiry_value                               = $data->expiry_value;
            $pv->supplier_id                                = $data->supplier_id;

            $pv->online_sale_price                          = $data->online_sell_price;
            $pv->online_mrp_price                           = $data->online_sell_price;
            $pv->retail_price                               = $data->sale_price;
            $pv->whole_sale_price                           = $data->whole_sale_price;
            $pv->reseller_price                             = $data->whole_sale_price;
            $pv->vip_price                                  = $data->whole_sale_price;
            $pv->mrp_price                                  = $data->mrp_price;

            //$pv->group_sale_price                           = $data->group_sale_price;
            $pv->purchase_unit_price_before_discount        = $data->purchase_price;
            $pv->purchase_unit_price_before_tax             = $data->purchase_price;
            $pv->purchase_unit_price_inc_tax                = $data->purchase_price;
            $pv->default_purchase_price                     = $data->purchase_price;
            $pv->unit_selling_price_inc_tax                 = $data->sale_price;
            $pv->unit_selling_price_exc_tax                 = $data->sale_price;
            $pv->default_selling_price                      = $data->sale_price;
            $pv->default_purchase_unit_id                   = $data->purchase_unit_id;
            $pv->default_sale_unit_id                       = $data->purchase_unit_id;
                                                             
            $pv->profit_amount                              = $data->sale_price - $data->purchase_price;
            $pv->created_by                                 = Auth::user()->id;
            $pv->save();
        }
        return true;
    }

    /* public function  __construct($company_id)
    {
        $this->company_id= $company_id;
    } */


   /*  public function model(array $row)
    {
        $data = new Product([
            'name' => $row[0],
            'sku' => $row[1],
            //'bar_code' => $row[2],
            'supplier_id' => $row[2],
            'purchase_price' => $row[3],   
        ]); 

        $data->save();
        $pv = new ProductVariation();
        $pv->product_id = $data->id;
        $pv->save();
    } */
}
