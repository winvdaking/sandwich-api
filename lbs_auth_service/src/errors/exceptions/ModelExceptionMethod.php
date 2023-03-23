<?php

namespace auth\errors\exceptions;

class ModelExceptionMethod extends \Exception
{
    protected $code = 405;
    protected $message = 'La méthode contenue dans la rêquete reçue n\'est pas autorisée sur l\'uri indiquée ; cette uri est cependant valide.';
    protected string $title = 'Méthode non acceptée';
    protected string $description = 'méthode non autorisée';
}
