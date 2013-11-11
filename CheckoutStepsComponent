<?php

    App::uses('Component', 'Controller');
    class CheckoutStepsComponent extends Component {

        public $components = array('Session');
        public $steps = array();

        function initialize(Controller $controller) {
            $this->controller = $controller;
            $this->steps = array(
                "login_register" => "address",
                "address" => "payment"
            );
            if($this->Session->check('UserAuth.Checkout')) {
                $this->currentStep = $this->Session->read('UserAuth.Checkout');
            }
        }

        function inCheckout() {
            return $this->Session->check('UserAuth.Checkout');
        }

        function setStep($action) {
            $this->Session->delete('UserAuth.Checkout');
            return $this->Session->write('UserAuth.Checkout', $action);
        }

        function nextStep() {

            $nextStep = $this->steps[$this->currentStep];
            $this->controller->redirect(array('plugin' => false, 'controller' => 'checkouts', 'action' => $nextStep));
        }

        function prevStep() {
            $previousStep = "";
            $previousStep = array_search($this->currentStep, $this->steps); // Finds the key associated with current step which will be the previous step!
            $this->controller->redirect(array('plugin' => false, 'controller' => 'checkouts', 'action' => $previousStep));
        }

        function currentStep() {
            $this->controller->redirect(array('plugin' => false, 'controller' => 'checkouts', 'action' => $this->currentStep));
        }

        function clear() {
            return $this->Session->delete('UserAuth.Checkout');
        }
    }
?>
