<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'لیست پیام ها ';
        $n = 12;
        $items = Contact::paginate(25);
        $grid = new \Datagrid($items);

        // Then we are starting to define columns
        $grid
            ->setColumn('subject', 'عنوان', [
                'sortable'    => true,
                'has_filters' => true
            ])
            ->setColumn('name', 'نام و نام خانوادگی', [
                'sortable'    => true,
                'has_filters' => true,
            ])
            ->setColumn('email', 'ایمیل', [
                'sortable'    => true,
                'has_filters' => true,
                // Wrapper closure will accept two params
                // $value is the actual cell value
                // $row are the all values for this row
                'wrapper'     => function ($value, $row) {
                    return '<a href="mailto:' . $value . '">' . $value . '</a>';
                }
            ])
            ->setColumn('phone', 'شماره تماس', [
                'sortable'    => true,
                'has_filters' => true,
            ])
            ->setColumn('created_at', 'Created', [
                'sortable'    => true,
                'has_filters' => true,
                'wrapper'     => function ($value, $row) {
                    // The value here is still Carbon instance, so you can format it using the Carbon methods
                    return $value;
                }
            ])
            ->setColumn('updated_at', 'Updated', [
                'sortable'    => true,
                'has_filters' => true
            ])
            // Setup action column
            ->setActionColumn([
                'wrapper' => function ($value, $row) {
                    return '<a href="' . action('HomeController@index', $row->id) . '" title="Edit" class="btn btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					<a href="' . action('HomeController@index', $row->id) . '" title="Delete" data-method="DELETE" class="btn btn-xs text-danger" data-confirm="Are you sure?"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
                }
            ]);

    }
}