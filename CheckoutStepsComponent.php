<?php

    App::uses('Component', 'Controller');
    class CheckoutStepsComponent extends Component {

        public $components = array('Session', 'Usermgmt.UserAuth');
        public $steps = array();

        function initialize(Controller $controller) {
            $this->controller = $controller;
            $this->steps = array(
                "login_register" => "address",
                "address" => "payment"
            );
            $this->firstStep = "address";
            $this->loginStep = "login_register";
            $this->sessionStore = "UserAuth.Checkout";

            if($this->Session->check($this->sessionStore)) {
                $this->currentStep = $this->Session->read($this->sessionStore);
            }
        }

        function inCheckout() {
            return $this->Session->check($this->sessionStore);
        }

        function start() {
            if($this->UserAuth->isLogged()) {
                $this->controller->redirect(array('plugin' => false, 'controller' => $this->controller->name, 'action' => $this->firstStep));
            } else {
                $this->controller->redirect(array('plugin' => false, 'controller' => $this->controller->name, 'action' => $this->loginStep));
            }
        }

        function setStep($action) {
            $this->Session->delete($this->sessionStore);
            return $this->Session->write($this->sessionStore, $action);
        }

        function nextStep() {

            $nextStep = $this->steps[$this->currentStep];
            $this->controller->redirect(array('plugin' => false, 'controller' => $this->controller->name, 'action' => $nextStep));
        }

        function prevStep() {
            $previousStep = "";
            $previousStep = array_search($this->currentStep, $this->steps); // Finds the key associated with current step which will be the previous step!
            $this->controller->redirect(array('plugin' => false, 'controller' => $this->controller->name, 'action' => $previousStep));
        }

        function currentStep() {
            $this->controller->redirect(array('plugin' => false, 'controller' => $this->controller->name, 'action' => $this->currentStep));
        }

        function clear() {
            return $this->Session->delete($this->sessionStore);
        }
    }
?>
