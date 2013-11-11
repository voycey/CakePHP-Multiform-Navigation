CakePHP-Multiform-Navigation
============================

Gives easy persistent logic to maintain what steps come next in a form regardless of if the user is redirected to a page outside of the form.

When you create a multi-page form, one of the hardest things is tracking the path through this form, especially when redirected off to another page. I created this so that regardless of where on the site they needed to go (for instance if they needed to login) the user could be easily redirected back into the correct part of the site after this was done.

Basically it is just a neat way of handling the Session Variables that need to be set:

To redirect to the current/ previous / next step:

```php
if($this->CheckoutSteps->inCheckout()) {
    $this->CheckoutSteps->nextStep();
}
```

The setup for this is done in the component (it could be done with a constructor better if you intend to re-use this!)

```php
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
```

And to set the steps up correctly automatically on the controller that handles the multiform requests you simply add the code to set the step in beforeFilter:

```php
public function beforeFilter() {
    parent::beforeFilter();
    $this->CheckoutSteps->setStep($this->action);
}
```

Hope this helps someone :)
