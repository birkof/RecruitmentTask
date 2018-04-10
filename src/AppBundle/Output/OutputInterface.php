<?php

namespace AppBundle\Output;

interface OutputInterface
{
    public function process(array $data = []);
}
