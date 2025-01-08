<?php


namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryCreateInputDto;
use Core\UseCase\DTO\Category\CategoryCreateOutputDto;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\CategoryOutputDto;
use \PHPUnit\Framework\TestCase;
use Mockery;
use Ramsey\Uuid\Uuid;
use stdClass;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\Domain\Entity\CategoryRepositoryInterface;

class ListCategoryUseCaseUnitTest extends TestCase
{
    public function testGetById()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid,
            "teste category"
        ]);

        $this->mockEntity->shouldReceive('id')->andReturn($uuid);
        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('findById')
            ->with($uuid)
            ->andReturn($this->mockEntity);


        $this->mockDTO = Mockery::mock(CategoryInputDto::class, [
            $uuid,
        ]);

        $useCase = new ListCategoryUseCase($this->mockRepository);
        $response = $useCase->execute($this->mockDTO);

        $this->assertInstanceOf(CategoryOutputDto::class, $response);
        $this->assertEquals("teste category", $response->name);
        $this->assertEquals('', $response->description);
        $this->assertEquals($uuid, $response->id);
        $this->assertTrue($response->is_active);

        /*
         * Spies
         * Garante a chamada do metodo insert
         * Caso o metodo não seja chamado gera uma exception
         */

        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')
            ->with($uuid)
            ->andReturn($this->mockEntity);
        $useCase = new ListCategoryUseCase($this->spy);
        $useCase->execute($this->mockDTO);
        $this->spy->showHaveReceived('findById');

        Mockery::close();
    }
}