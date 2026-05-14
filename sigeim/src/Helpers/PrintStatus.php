<?php

namespace App\Helpers;

/**
 * Helper to manage Print Job Statuses
 */
class PrintStatus {
    const PENDING    = 'pendiente';
    const IN_QUEUE   = 'en_cola';
    const PRINTING   = 'imprimiendo';
    const COMPLETED  = 'completado';
    const ERROR      = 'error';
    const CANCELLED  = 'cancelado';

    /**
     * Get all possible statuses
     */
    public static function all() {
        return [
            self::PENDING,
            self::IN_QUEUE,
            self::PRINTING,
            self::COMPLETED,
            self::ERROR,
            self::CANCELLED
        ];
    }

    /**
     * Get label for a status
     */
    public static function label($status) {
        $labels = [
            self::PENDING    => 'Pendiente',
            self::IN_QUEUE   => 'En Cola',
            self::PRINTING   => 'Imprimiendo',
            self::COMPLETED  => 'Completado',
            self::ERROR      => 'Error',
            self::CANCELLED  => 'Cancelado'
        ];
        return $labels[$status] ?? 'Desconocido';
    }

    /**
     * Get color class for Bootstrap badges
     */
    public static function color($status) {
        $colors = [
            self::PENDING    => 'secondary',
            self::IN_QUEUE   => 'info',
            self::PRINTING   => 'primary',
            self::COMPLETED  => 'success',
            self::ERROR      => 'danger',
            self::CANCELLED  => 'dark'
        ];
        return $colors[$status] ?? 'secondary';
    }
}
