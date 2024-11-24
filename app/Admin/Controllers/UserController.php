<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'));
        /* $grid->column('password', __('Password'));
        $grid->column('remember_token', __('Remember token'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at')); */
        $grid->column('post_code', __('Post code'));
        $grid->column('address', __('Address'));
        $grid->column('phone_number', __('Phone number'));
        $grid->column('premium_member', __('Premium member'))->sortable();
        $grid->column('premium_member_expiration', __('Premium member expiration'));
        $grid->column('cancellation_date', __('Cancellation date'))->sortable();
        $grid->column('stripe_id', __('Stripe id'));
        $grid->column('pm_type', __('Pm type'));
        $grid->column('pm_last_four', __('Pm last four'));
        $grid->column('trial_ends_at', __('Trial ends at'));
        /* $grid->column('deleted_at', __('Deleted at')); */
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();
        $grid->column('deleted_at', __('Deleted at'))->sortable();

        $grid->filter(function($filter) {
            $filter->like('name', 'ユーザー名');
            $filter->like('email', 'メールアドレス');
            $filter->like('postal_code', '郵便番号');
            $filter->like('address', '住所');
            $filter->like('phone', '電話番号');
            $filter->between('created_at', '登録日')->datetime();
            $filter->scope('trashed', 'Soft deleted data')->onlyTrashed();
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        /* $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at')); */
        $show->field('post_code', __('Post code'));
        $show->field('address', __('Address'));
        $show->field('phone_number', __('Phone number'));
        $show->field('premium_member', __('Premium member'));
        $show->field('premium_member_expiration', __('Premium member expiration'));
        $show->field('cancellation_date', __('Cancellation date'));
        $show->field('stripe_id', __('Stripe id'));
        $show->field('pm_type', __('Pm type'));
        $show->field('pm_last_four', __('Pm last four'));
        $show->field('trial_ends_at', __('Trial ends at'));
        /* $show->field('deleted_at', __('Deleted at')); */
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        /* $form->text('remember_token', __('Remember token')); */
        $form->text('post_code', __('Post code'));
        $form->textarea('address', __('Address'));
        $form->text('phone_number', __('Phone number'));
        $form->switch('premium_member', __('Premium member'));
        $form->date('premium_member_expiration', __('Premium member expiration'))->default(date('Y-m-d'));
        $form->date('cancellation_date', __('Cancellation date'))->default(date('Y-m-d'));
        $form->text('stripe_id', __('Stripe id'));
        $form->text('pm_type', __('Pm type'));
        $form->text('pm_last_four', __('Pm last four'));
        $form->datetime('trial_ends_at', __('Trial ends at'))->default(date('Y-m-d H:i:s'));
        $form->datetime('deleted_at', __('Deleted at'))->default(NULL);
        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            } else {
                $form->password = $form->model()->password;
            }
        });

        return $form;
    }
}
