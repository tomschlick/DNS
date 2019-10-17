<?php

/*
 * This file is part of Badcow DNS Library.
 *
 * (c) Samuel Williams <sam@badcow.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Badcow\DNS\Rdata;

/**
 * {@link https://tools.ietf.org/html/rfc4255}.
 */
class SSHFP implements RdataInterface
{
    use RdataTrait;

    const TYPE = 'SSHFP';
    const TYPE_CODE = 44;
    const ALGORITHM_RSA = 1;
    const ALGORITHM_DSA = 2;
    const FP_TYPE_SHA1 = 1;

    /**
     * 8-bit algorithm designate.
     *
     * @var int
     */
    private $algorithm;

    /**
     * 8-bit Fingerprint type.
     *
     * @var int
     */
    private $fingerprintType = self::FP_TYPE_SHA1;

    /**
     * Hexadecimal string.
     *
     * @var string
     */
    private $fingerprint;

    /**
     * @return int
     */
    public function getAlgorithm(): int
    {
        return $this->algorithm;
    }

    /**
     * @param int $algorithm
     *
     * @throws \InvalidArgumentException
     */
    public function setAlgorithm(int $algorithm): void
    {
        if ($algorithm < 0 || $algorithm > 255) {
            throw new \InvalidArgumentException('Algorithm must be an 8-bit integer between 0 and 255.');
        }
        $this->algorithm = $algorithm;
    }

    /**
     * @return int
     */
    public function getFingerprintType(): int
    {
        return $this->fingerprintType;
    }

    /**
     * @param int $fingerprintType
     *
     * @throws \InvalidArgumentException
     */
    public function setFingerprintType(int $fingerprintType): void
    {
        if ($fingerprintType < 0 || $fingerprintType > 255) {
            throw new \InvalidArgumentException('Fingerprint type must be an 8-bit integer between 0 and 255.');
        }
        $this->fingerprintType = $fingerprintType;
    }

    /**
     * @return string
     */
    public function getFingerprint(): string
    {
        return $this->fingerprint;
    }

    /**
     * @param string $fingerprint
     */
    public function setFingerprint(string $fingerprint): void
    {
        if (1 !== preg_match('/^[0-9a-f]+$/i', $fingerprint)) {
            throw new \InvalidArgumentException('The fingerprint MUST be a hexadecimal value.');
        }
        $this->fingerprint = $fingerprint;
    }

    /**
     * {@inheritdoc}
     */
    public function toText(): string
    {
        return sprintf('%d %d %s', $this->algorithm, $this->fingerprintType, $this->fingerprint);
    }
}
