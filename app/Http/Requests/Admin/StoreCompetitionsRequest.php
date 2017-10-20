<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 28.09.17
 * Time: 12:41
 */

namespace App\Http\Requests\Admin;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompetitionsRequest extends FormRequest
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

    public function all()
    {
        $input = parent::all();
        $input['start_date'] = $this->dateConverter($input['start_date']);
        $input['submit_date'] = $this->dateConverter($input['submit_date']);

        return $input;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_date' => 'date_format:'.config('app.date_format'),
            'submit_date' => 'date_format:'.config('app.date_format'),
        ];
    }

    protected function dateConverter($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}