<?php

namespace App\Admin\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RestaurantController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Restaurant';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Restaurant());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('category.name', __('Category Name'));
        $grid->column('name', __('Name'));
        $grid->column('image', __('Image'))->image();
        $grid->column('description', __('Description'));
        $grid->column('lowest_price', __('Lowest price'))->sortable();
        $grid->column('highest_price', __('Highest price'));
        $grid->column('phone_number', __('Phone number'));
        $grid->column('open_time', __('Open time'));
        $grid->column('close_time', __('Close time'));
        $grid->column('closed_day', __('Closed day'));
        $grid->column('post_code', __('Post code'));
        $grid->column('address', __('Address'));
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->filter(function($filter) {
            $filter->like('name', '店舗名');
            $filter->like('description', '店舗説明');
            $filter->between('lowest price', '最低金額');
            $filter->in('category_id', 'カテゴリー')->multipleSelect(Category::all()->pluck('name', 'id'));
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Restaurant::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category.name', __('Category Name'));
        $show->field('name', __('Name'));
        $show->field('image', __('Image'))->image();
        $show->field('description', __('Description'));
        $show->field('lowest_price', __('Lowest price'));
        $show->field('highest_price', __('Highest price'));
        $show->field('phone_number', __('Phone number'));
        $show->field('open_time', __('Open time'));
        $show->field('close_time', __('Close time'));
        $show->field('closed_day', __('Closed day'));
        $show->field('post_code', __('Post code'));
        $show->field('address', __('Address'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Restaurant());

        $form->select('category_id', __('Category Name'))->options(Category::all()->pluck('name', 'id'));
        $form->text('name', __('Name'));
        $form->image('image', __('Image'));
        $form->textarea('description', __('Description'));
        $form->number('lowest_price', __('Lowest price'));
        $form->number('highest_price', __('Highest price'));
        $form->text('phone_number', __('Phone number'));
        $form->time('open_time', __('Open time'))->default(date('H:i:s'));
        $form->time('close_time', __('Close time'))->default(date('H:i:s'));
        $form->text('closed_day', __('Closed day'));
        $form->text('post_code', __('Post code'));
        $form->text('address', __('Address'));

        return $form;
    }
}
