<?php

enum Role {
    case Customer;
    case Admin;
    case Employee;
}

class User {
    protected int $id;
    protected int $role;
    protected string $name;
    protected string $email;
    protected string $password;
    protected DateTime $registrationDate;
    protected string $picture = "";
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): string
    {
        return $this->id;
    }
    /**
     * Get the value of role
     *
     * @return enum Role
     */
    public function getRole(): int
    {
        return $this->role;
        // if($this->role == 1) return Role Customer;
        // if($this->role == 2) return Admin;
        // if($this->role == 3) return Employee;
        // return Employee;
    }
    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    /**
     * Get the value of hashed password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getEmail(): string {
        return $this->email;
    }
}