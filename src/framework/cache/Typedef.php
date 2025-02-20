<?php
/************************************************************************
* @file Typedef.php
*************************************************************************
* This file is part of the CapitanPHP framework.
*************************************************************************
* Copyright (c) 2025 CapitanPHP.
*************************************************************************
* Licensed (https:
*************************************************************************
* Author: capitan <capitanPHP@tutamail.com>
**************************************************************************/
namespace capitan\cache;
interface Typedef
{
    public function get(string $key) : string|array|int|object;
    public function set(string $key, string|array|int|object $value, int $expiration = 0) : bool;
    public function has(string $key) : bool;
    public function delete(string $key) : bool;
    public function fp(string $key) : void;
}