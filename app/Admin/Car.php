<?php
/**
 * Конфигурация админки машин
 *
 * TODO: автоподгрузка адресов
 */

use App\Car;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Car::class, function (ModelConfiguration $model) {
    $model->setTitle('Машины');
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            AdminColumn::link('id')->setLabel('ID'),
            AdminColumn::link('car')->setLabel('Машина'),
            AdminColumn::link('driver')->setLabel('Водитель'),
            AdminColumn::link('license_plate')->setLabel('Номер'),
            AdminColumn::text('is_active')->setLabel('Активность'),
        ]);
        $display->paginate(15);
        return $display;
    });
    // Create And Edit
    $model->onCreateAndEdit(function() {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('car', 'Машина')->required(),
            AdminFormElement::text('driver', 'Водитель')->required()->unique(),
            AdminFormElement::text('license_plate', 'Номер')->required()->unique(),
            AdminFormElement::textarea('comment', 'Комментарий')->setRows(5),
            AdminFormElement::text('location', 'Текущее местоположение'),
            AdminFormElement::text('latitude', 'Широта'),
            AdminFormElement::text('longitude', 'Долгота'),
            AdminFormElement::checkbox('is_active', 'Активная')
        );
        return $form;
    });
})
    ->addMenuPage(Car::class, 0)
    ->setIcon('fa fa-truck');