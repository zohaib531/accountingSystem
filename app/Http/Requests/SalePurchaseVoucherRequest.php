<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalePurchaseVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "credit_dates"    => ['required','array'],
            "credit_dates.*"  => ['required'],
            "credit_accounts"    => ['required','array'],
            "credit_accounts.*"  => ['required'],
            "credit_products"    => ['required','array'],
            "credit_products.*"  => ['required'],
            "credit_quantities"    => ['required','array'],
            "credit_quantities.*"  => ['required'],
            "credit_rates"    => ['required','array'],
            "credit_rates.*"  => ['required'],
            "credit_amounts"    => ['required','array'],
            "credit_amounts.*"  => ['required'],
            "debit_dates"    => ['required','array'],
            "debit_dates.*"  => ['required'],
            "debit_accounts"    => ['required','array'],
            "debit_accounts.*"  => ['required'],
            "debit_products"    => ['required','array'],
            "debit_products.*"  => ['required'],
            "debit_quantities"    => ['required','array'],
            "debit_quantities.*"  => ['required'],
            "debit_rates"    => ['required','array'],
            "debit_rates.*"  => ['required'],
            "debit_amounts"    => ['required','array'],
            "debit_amounts.*"  => ['required'],
            "total_debit" => ['required','same:total_credit']
        ];
    }

    public function response(array $errors)
    {
        // Optionally, send a custom response on authorize failure 
        // (default is to just redirect to initial page with errors)
        // 
        // Can return a response, a view, a redirect, or whatever else

        if ($this->ajax() || $this->wantsJson()){return new JsonResponse($errors, 422);}
        return $this->redirector->to('login')
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }
}
