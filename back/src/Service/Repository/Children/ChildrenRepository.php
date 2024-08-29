<?php
declare(strict_types=1);

namespace App\Service\Repository\Children;

use App\Exception\Children\NoDataException;
use App\Service\Security\FileEncoder;
use App\ValueObject\Children\Child;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ChildrenRepository
{
    private const FILE_NAME = 'children.bin';
    private const NONCE = '4701f5e94e7508b9213bbd4fd61d460675c2e3f01924305e';

    public function __construct(
        private readonly FileEncoder $fileEncoder,
        private readonly string $childrenPath,
        private readonly DenormalizerInterface $denormalizer,
        private readonly SerializerInterface $serializer,
    ) {}

    /**
     * @return Child[]
     */
    public function get(): array
    {
        $childrenJson = json_decode(
            $this->fileEncoder->decode(
                file_get_contents($this->getPath()),
                hex2bin(self::NONCE)
            ),
            true
        );

        if (!isset($childrenJson['data']['children'])) {
            throw new NoDataException();
        }

        $children = [];
        foreach ($childrenJson['data']['children'] as $child) {
            $children[] = $this->denormalizer->denormalize($child, Child::class);
        }

        return $children;
    }

    public function save(string $children): void
    {
        $fs = new Filesystem();
        $data = $this->fileEncoder->encode(
            $this->serializer->serialize(
                [
                    'data' => [
                        'children' => [json_decode($children, true)],
                    ],
                    'metadata' => [
                        'created' => Carbon::now(),
                    ],
                ],
                'json'
            ),
            hex2bin(self::NONCE)
        );

        $fs->dumpFile(
            $this->getPath(),
            $data
        );
    }

    private function getPath(): string
    {
        return sprintf('%s%s', $this->childrenPath, self::FILE_NAME);
    }
}
