<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 16/06/2019
 * Time: 23:26
 */

namespace App\Entity;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "mot de passe incorrect"
     * )
     */
    public $oldPassword;

    /**
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "mot de passe doit contenir 6 caractére au miniumum"
     * )
     */
    public $newPassword;

}