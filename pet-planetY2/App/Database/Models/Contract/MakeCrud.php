<?php

namespace App\Database\Models\Contract;


interface MakeCrud
{
    function create(): bool;
    function read(): array;
    function update(): bool;
    function delete(): bool;

    function readO(): \mysqli_result;
}
