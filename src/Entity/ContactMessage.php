<?php


namespace App\Entity;

use App\Repository\ContactMessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Représente un message envoyé via le formulaire de contact.
 */
#[ORM\Entity(repositoryClass: ContactMessageRepository::class)]
class ContactMessage
{
    /**
     * Clé primaire auto-incrémentée.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Nom complet de la personne qui contacte.
     */
    #[ORM\Column(length: 255)]
    private ?string $fullname = null;

    /**
     * Adresse e-mail de contact.
     */
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * Sujet du message.
     */
    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    /**
     * Contenu du message.
     */
    #[ORM\Column(type: 'text')]
    private ?string $message = null;

    /**
     * Date/heure d'envoi.
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * Indique si le message a été lu dans l'interface admin (plus tard).
     */
    #[ORM\Column]
    private bool $isRead = false;

    public function __construct()
    {
        // On initialise la date d'envoi par défaut à "maintenant"
        $this->createdAt = new \DateTimeImmutable();
        $this->isRead = false;
    }

    // ----------------- GETTERS / SETTERS -----------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isRead(): bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }
}
