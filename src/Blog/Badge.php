<?php
/**
 * Gabyfle
 * Badge.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
namespace Gabyfle\Blog;

/**
 * Class Badge
 * @package Gabyfle\Blog
 */
class Badge
{
    private $types = [
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'light',
        'dark'
    ];

    /**
     * createBadge
     * Insert a new badge in the database
     * @param string $name
     * @param string $text
     * @param string $type
     * @throws \Exception
     */
    public function createBadge(string $name, string $text, string $type)
    {
        if (!in_array($type, $this->types)) {
            throw new \Exception('Unknown badge type');
        }
    }

    /**
     * deleteBadge
     * Delete a badge from the database
     * @param string $name
     */
    public function deleteBadge(string $name)
    {

    }

    /**
     * getBadges
     * Get all the badges names
     */
    public function getBadges()
    {

    }
}