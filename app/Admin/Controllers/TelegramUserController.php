<?php

namespace App\Admin\Controllers;

use App\Models\TelegramUser;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramUserController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TelegramUser);

        $grid->id('Id');
        $grid->name('Name');
        $grid->phone('Phone');
        $grid->photo('Photo')->display(function ($path) {
            $domain = $_SERVER['SERVER_NAME'];
            return "<img src='http://$domain:8000/$path' alt=''>";
        });;
        $grid->comment('Comment');
        $grid->category('Category');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->tools(function ($tools) {
            $tools->append('<a class="btn btn-success" href="/change_photo">Change photo to send</a>');
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
        $show = new Show(TelegramUser::findOrFail($id));

        $show->id('Id');
        $show->phone('Phone');
        $show->photo('Photo');
        $show->comment('Comment');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->name('Name');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TelegramUser);

        $form->mobile('phone', 'Phone');
        $form->image('photo', 'Photo');
        $form->textarea('comment', 'Comment');
        $form->text('name', 'Name');

        return $form;
    }
}
