<?php declare(strict_types=1);


namespace DownloadBooster;


/**
 * Class Download
 *
 * Represents the settings to be used for a download
 *
 * @package DownloadBooster
 */
class Download
{
    private $url;
    private $chunkCount;
    private $chunkSize;
    private $data;

    /**
     * @param string|null $url
     * @param int|null $chunkCount
     * @param int|null $chunkSize
     */
    public function __construct(?string $url = null, ?int $chunkCount = null, ?int $chunkSize = null)
    {
        $this->setURL($url)
            ->setChunkCount($chunkCount)
            ->setChunkSize($chunkSize);
    }

    /**
     * @param string $url
     * @return Download
     */
    public function setURL(?string $url): Download
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("The url '${url}' appears to be invalid.");
        }

        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getURL(): string
    {
        return $this->url;
    }

    /**
     * @param int|null $chunkCount
     * @return Download
     */
    public function setChunkCount(?int $chunkCount): Download
    {
        if ($chunkCount < 1) {
            throw new \InvalidArgumentException("Chunk count of ${chunkCount} is not valid. Must be >= 1.");
        }

        $this->chunkCount = $chunkCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getChunkCount(): int
    {
        return $this->chunkCount;
    }

    /**
     * @param int|null $chunkSize
     * @return Download
     */
    public function setChunkSize(?int $chunkSize): Download
    {
        if ($chunkSize < 1) {
            throw new \InvalidArgumentException("Chunk size of ${chunkSize} is not valid. Must be >= 1.");
        }

        $this->chunkSize = $chunkSize;
        return $this;
    }

    /**
     * @return int
     */
    public function getChunkSize(): int
    {
        return $this->chunkSize;
    }

    /**
     * Stores the downloaded data
     *
     * To prevent accidental requests, the data property can only be set once, and cannot be set from the constructor.
     * This method must remain fluent to work around a mutability issue that occurs during parallel operation.
     *
     * @param string $data
     * @return Download
     */
    public function setData($data): Download
    {
        if (!is_null($this->data)) {
            throw new \LogicException('Data for a download should only be set once. Data already set.');
        }

        $this->data = $data;
        return $this;
    }

    /**
     * Returns the downloaded data
     *
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }
}