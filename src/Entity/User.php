<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email déjà pris")
 * @UniqueEntity(fields="username", message="Username déjà pris")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(type="boolean")
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Expense", mappedBy="userId")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $expenses;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getUsername();
    }
    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $role = $this->role;

        if ($role) {
            $roles[] = 'ROLE_ADMIN';
            $roles[] = 'ROLE_USER';
        } else {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    /**
     * @param bool $role
     */
    public function setRole(bool $role)
    {
        $this->role = $role ? 1 : 0;
    }

    /**
     * Retour le salt qui a servi à coder le mot de passe
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one

        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // Nous n'avons pas besoin de cette methode car nous n'utilions pas de plainPassword
        // Mais elle est obligatoire car comprise dans l'interface UserInterface
        // $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return serialize([$this->id, $this->username, $this->password]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * @return mixed
     */
    public function getExpenses()
    {
        return $this->expenses;
    }


    public function setExpenses($expenses)
    {
        $this->expenses = $expenses;

        return $this;
    }

}