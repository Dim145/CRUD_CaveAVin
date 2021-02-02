<?php


interface DataBaseObject
{
    function saveInDB(): void;
    function setObjects(): void;
    function __toString(): string;
}