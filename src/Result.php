<?php

declare(strict_types=1);

/*
 * This file is part of Result Type.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\ResultType;

use PhpOption\Option;

/**
 * @template-covariant TSuccess
 * @template-covariant TError
 * @immutable
 */
abstract class Result
{
    /**
     * Get the success option value.
     *
     * @return \PhpOption\Option<TSuccess>
     */
    abstract public function success(): Option;

    /**
     * Map over the success value.
     *
     * @template TNewSuccess
     *
     * @param callable(TSuccess):TNewSuccess $f
     *
     * @return \GrahamCampbell\ResultType\Result<TNewSuccess,TError>
     */
    abstract public function map(callable $f): Result;

    /**
     * Flat map over the success value.
     *
     * @template TNewSuccess
     * @template TNewError
     *
     * @param callable(TSuccess):\GrahamCampbell\ResultType\Result<TNewSuccess,TNewError> $f
     *
     * @return \GrahamCampbell\ResultType\Result<TNewSuccess,TError|TNewError>
     */
    abstract public function flatMap(callable $f): Result;

    /**
     * Get the error option value.
     *
     * @return \PhpOption\Option<TError>
     */
    abstract public function error(): Option;

    /**
     * Map over the error value.
     *
     * @template TNewError
     *
     * @param callable(TError):TNewError $f
     *
     * @return \GrahamCampbell\ResultType\Result<TSuccess,TNewError>
     */
    abstract public function mapError(callable $f): Result;
}
