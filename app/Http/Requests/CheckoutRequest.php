<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

   /* public function messages()
    {
        return [
            'email.exists'=>'Email does not exist',
        ];
    }*/
    public function rules()
    {
        return [
            // "billing_first_name"=>"required",
            // "billing_last_name"=>"required",
            // "billing_email"=>"required|email|max:255",
            // "billing_phone"=>"required|min:11",
            // "billing_country"=>"required",
            // "billing_city"=>"required",
            // "billing_state"=>"required",
            // "billing_address"=>"required",
            // "billing_zip"=>"required",
            // "payment_merchant"=>"required",
        ];
    }
}
