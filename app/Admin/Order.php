<?php
/**
 * Конфигурация админки заказов
 *
 * TODO: автоподгрузка адресов
 */

use App\Order;
use App\Car;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Order::class, function (ModelConfiguration $model) {
    $model->setTitle('Заказы');
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        //$display->with('Car');
        //TODO: сделать нормальное отображенение машины, хотя бы номер
        $display->setColumns([
            AdminColumn::link('id')->setLabel('ID'),
            AdminColumn::link('car_id')->setLabel('Машина'),
            AdminColumn::link('customer')->setLabel('Покупатель'),
            AdminColumn::link('price')->setLabel('Сумма'),
            AdminColumn::link('address')->setLabel('Адрес'),
            AdminColumn::text('status')->setLabel('Статус'),
        ]);
        $display->paginate(15);
        return $display;
    });
    // Create And Edit
    $model->onCreateAndEdit(function() {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('customer', 'Покупатель')->required(),
            AdminFormElement::text('price', 'Сумма')->required(),
            AdminFormElement::text('address', 'Адрес')->required(),
            AdminFormElement::textarea('comment', 'Комментарий')->setRows(5),
            AdminFormElement::select('car_id', 'Машина')->setModelForOptions(new Car())->setDisplay('license_plate'),
            AdminFormElement::select('status', 'Статус')->setOptions([
                'new' => 'Новый',
                'in_delivery' => 'Доставляется',
                'success' => 'Доставлен',
                'canceled' => 'Отменен'
            ])
        );
        return $form;
    });
})
    ->addMenuPage(Order::class, 0)
    ->setIcon('fa fa-dropbox');