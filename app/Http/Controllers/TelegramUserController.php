<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTelegramUserRequest;
use App\Http\Requests\UpdateTelegramUserRequest;
use App\Repositories\TelegramUserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TelegramUserController extends AppBaseController
{
    /** @var  TelegramUserRepository */
    private $telegramUserRepository;

    public function __construct(TelegramUserRepository $telegramUserRepo)
    {
        $this->telegramUserRepository = $telegramUserRepo;
    }

    /**
     * Display a listing of the TelegramUser.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->telegramUserRepository->pushCriteria(new RequestCriteria($request));
        $telegramUsers = $this->telegramUserRepository->all();

        return view('telegram_users.index')
            ->with('telegramUsers', $telegramUsers);
    }

    /**
     * Show the form for creating a new TelegramUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('telegram_users.create');
    }

    /**
     * Store a newly created TelegramUser in storage.
     *
     * @param CreateTelegramUserRequest $request
     *
     * @return Response
     */
    public function store(CreateTelegramUserRequest $request)
    {
        $input = $request->all();

        $telegramUser = $this->telegramUserRepository->create($input);

        Flash::success('Telegram User saved successfully.');

        return redirect(route('telegramUsers.index'));
    }

    /**
     * Display the specified TelegramUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $telegramUser = $this->telegramUserRepository->findWithoutFail($id);

        if (empty($telegramUser)) {
            Flash::error('Telegram User not found');

            return redirect(route('telegramUsers.index'));
        }

        return view('telegram_users.show')->with('telegramUser', $telegramUser);
    }

    /**
     * Show the form for editing the specified TelegramUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $telegramUser = $this->telegramUserRepository->findWithoutFail($id);

        if (empty($telegramUser)) {
            Flash::error('Telegram User not found');

            return redirect(route('telegramUsers.index'));
        }

        return view('telegram_users.edit')->with('telegramUser', $telegramUser);
    }

    /**
     * Update the specified TelegramUser in storage.
     *
     * @param  int              $id
     * @param UpdateTelegramUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTelegramUserRequest $request)
    {
        $telegramUser = $this->telegramUserRepository->findWithoutFail($id);

        if (empty($telegramUser)) {
            Flash::error('Telegram User not found');

            return redirect(route('telegramUsers.index'));
        }

        $telegramUser = $this->telegramUserRepository->update($request->all(), $id);

        Flash::success('Telegram User updated successfully.');

        return redirect(route('telegramUsers.index'));
    }

    /**
     * Remove the specified TelegramUser from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $telegramUser = $this->telegramUserRepository->findWithoutFail($id);

        if (empty($telegramUser)) {
            Flash::error('Telegram User not found');

            return redirect(route('telegramUsers.index'));
        }

        $this->telegramUserRepository->delete($id);

        Flash::success('Telegram User deleted successfully.');

        return redirect(route('telegramUsers.index'));
    }
}
