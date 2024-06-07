<?php

namespace App\Entity;

class User
{
    private String $idUser;

    private String $passwd;

    private String $profilePicture;

    private String $description;

    public function __construct($idUser, $passwd, $profilePicture, $description)
    {
        $this->idUser = $idUser;
        $this->passwd = $passwd;
        $this->profilePicture = $profilePicture;
        $this->description = $description;
    }

    /**
     * @return String
     */
    public function getIdUser(): string
    {
        return $this->idUser;
    }

    /**
     * @return String
     */
    public function getDescription(): String
    {
        return $this->description;
    }

    /**
     * @return String
     */
    public function getPasswd(): string
    {
        return $this->passwd;
    }

    /**
     * @return String
     */
    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    /**
     * @param String $description
     */
    public function setDescription(String $description): void
    {
        $this->description = $description;
    }

    /**
     * @param String $idUser
     */
    public function setIdUser(string $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @param String $passwd
     */
    public function setPasswd(string $passwd): void
    {
        $this->passwd = $passwd;
    }

    /**
     * @param String $profilePicture
     */
    public function setProfilePicture(string $profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }

}