<?php


namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\UseCase\DTO\Category\CategoryCreateInputDto;
use Core\UseCase\DTO\Category\CategoryCreateOutputDto;
use \PHPUnit\Framework\TestCase;
use Mockery;
use Ramsey\Uuid\Uuid;
use stdClass;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\Domain\Entity\CategoryRepositoryInterface;

class CreateCategoryUseCaseUnitTest extends TestCase
{
    public function testCreateNewCategory()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $categoryName = 'Name category';
        $mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $categoryName
        ]);

        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('insert')->andReturn($mockEntity);


        $this->mockDTO = Mockery::mock(CategoryCreateInputDto::class, [
            $categoryName,
        ]);

        $useCase = new CreateCategoryUseCase($this->mockRepository);
        $response = $useCase->execute($this->mockDTO);

        $this->assertInstanceOf(CategoryCreateOutputDto::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals('', $response->description);
        $this->assertTrue($response->is_active);

        /*
         * Spies
         * Garante a chamada do metodo insert
         * Caso o metodo não seja chamado gera uma exception
         */

        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($mockEntity);
        $useCase = new CreateCategoryUseCase($this->spy);
        $response = $useCase->execute($this->mockDTO);
        $this->spy->showHaveReceived('insert');

        Mockery::close();
    }
}