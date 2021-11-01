<?php
declare(strict_types = 1);

namespace DViewer;

class DViewer {

    private $path;

    public function __construct(string $path = null)
    {
        if ($path !== null) {
            $this->setPath($path);
        }
    }

    public function setPath(string $path): self
    {
        $realpath = realpath($path);

        if ($realpath === false || !is_dir($realpath)) {
            throw new \Exception("Invalid path: {$path}");
        }

        $this->path = rtrim($realpath, '/') . '/';

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFiles(): array
    {
        return array_diff(scandir($this->path), array('.', '..'));
    }

    private function _create_metadata($cellIterator): array {
        $obj = [];
        foreach ($cellIterator as $cell) {
            $obj[] = $cell->getValue();
        }    
        return $obj;
    }    

    public function getFile(string $file): array
    {
        $realfile = realpath($this->path . $file);

        if (dirname($realfile) . '/' != $this->path) {
            throw new \Exception('Invalid file path');
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($realfile);
        $worksheet = $spreadsheet->getActiveSheet();
    
        $lines = [];
        $i = -1;
        foreach ($worksheet->getRowIterator() as $row) {
            $i++;
    
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); 
    
            if ($i == 0) {
                // header
                $metadata = $this->_create_metadata($cellIterator);
                continue;
            }
    
            $j = 0;
            $line = [];
            foreach ($cellIterator as $cell) {
                $line[$metadata[$j]] = $cell->getValue();
                $j++;
            }
            $lines[] = $line;
        }
        // debug($metadata);
        return ['header' => $metadata, 'rows' => $lines];
    }
}