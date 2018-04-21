<?php
namespace kvush\controllers;


use kvush\core\Controller;

/**
 * Class SiteController
 *
 * @package kvush\controllers
 */
class SiteController extends Controller
{
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render("index");
    }
}
