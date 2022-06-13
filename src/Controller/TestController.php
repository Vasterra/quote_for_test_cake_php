<?php


namespace App\Controller;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\TableRegistry;

class TestController extends AppController
{
    public function index() {
        $flag = "a";
//        $flag_model = $this->getTableLocator()->get('AbFlag')->find()->where(['flag' => 'a'])->first();
//        dd($flag_model);

        if(!$this->request->getCookie('visitor') || $this->request->getData('clear_cookie')) {
            // set cookie
            $cookie_val = 'visitor_'.time();
            setcookie('visitor', $cookie_val, time() + 60 * 60 * 24 * 30);

            // Insert cookie value into DB
            $cookies_check_model = $this->getTableLocator()->get('CookiesCheck');
            $cookie_entity = $cookies_check_model->newEmptyEntity();
            $cookie_entity->cookie_value = $cookie_val;
            $cookies_check_model->save($cookie_entity);

            // set flag A || B
            $flag_model = $this->getTableLocator()->get('AbFlag');
            if(is_null($flag_model->find()->first())) {
                $flag_entity = $flag_model->newEmptyEntity();
                $flag_entity->flag = 'a';
                $flag_model->save($flag_entity);
            } else {
                $flag = $flag_model->find()->first()->flag;
                $flag_id = $flag_model->find()->first();
                if ($flag == 'a') {
                    $flag_entity = $flag_model->get($flag_id->id);
                    $flag_entity->flag = 'b';
                }
                if ($flag == 'b') {
                    $flag_entity = $flag_model->get($flag_id->id);
                    $flag_entity->flag = 'a';
                }
                $flag_model->save($flag_entity);
            }

            // set results into ab_test_results table
            $ab_results_model = $this->getTableLocator()->get('AbTestResults');
            $results_entity = $ab_results_model->find()->first();
            if($flag == 'a') {
                $results_entity->num_visitors_for_b += 1;
            } else {
                $results_entity->num_visitors_for_a += 1;
            }
            $ab_results_model->save($results_entity);
            $this->redirect('/');
        }

        // set clicked flag for cookies_check table

        if($this->request->getData('flag') && $this->request->getCookie('visitor')) {
            $cookie_check_model = $this->getTableLocator()->get('CookiesCheck');
            $cookie_check = $cookie_check_model->find()->where([
                'clicked'       => false,
                'cookie_value'  => $this->request->getCookie('visitor')
            ])->first();
            if($cookie_check) {
                $cookie_check->clicked = true;
                $cookie_check_model->save($cookie_check);

                // count++ in ab_test_results
                $ab_results_model = $this->getTableLocator()->get('AbTestResults');
                $results_entity = $ab_results_model->find()->first();
                if($this->request->getData('flag') == 'a') {
                    $results_entity->num_clicks_for_a += 1;
                } else {
                    $results_entity->num_clicks_for_b += 1;
                }
                $ab_results_model->save($results_entity);
            }
            $this->redirect('/');
        }

        $flag_model = $this->getTableLocator()->get('AbFlag')->find()->first();
        $this->set(['flag' => $flag_model->flag]);
    }

    public function report() {
        $report_data = $this->getTableLocator()->get('AbTestResults')->find()->first();

        $this->set(compact('report_data'));
    }
}
