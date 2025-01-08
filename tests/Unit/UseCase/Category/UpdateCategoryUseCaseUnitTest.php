<?php


namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryCreateInputDto;
use Core\UseCase\DTO\Category\CategoryCreateOutputDto;
use Core\UseCase\DTO\Category\CategoryUpdateInputDto;
use Core\UseCase\DTO\Category\CategoryUpdateOutputDto;
use \PHPUnit\Framework\TestCase;
use Mockery;
use Ramsey\Uuid\Uuid;
use stdClass;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\Domain\Entity\CategoryRepositoryInterface;

class UpdateCategoryUseCaseUnitTest extends TestCase
{
    public function testRenameCategory()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $categoryName = 'Name category';
        $categoryDescription = 'Desc category';
        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $categoryName,
            $categoryDescription,
        ]);

        $this->mockEntity->shouldReceive('update')->times(1);

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('findById')
            ->times(1)
            ->andReturn($this->mockEntity);
        $this->mockRepository->shouldReceive('update')
            ->times(1)
            ->andReturn($this->mockEntity);


        $this->mockDTO = Mockery::mock(CategoryUpdateInputDto::class, [
            $uuid,
            "new name",
        ]);

        $useCase = new UpdateCategoryUseCase($this->mockRepository);
        $response = $useCase->execute($this->mockDTO);

        $this->assertInstanceOf(CategoryUpdateOutputDto::class, $response);

        var_dump("---------------------->");
        var_dump($response->name);
        //$this->assertEquals("new name", $response->name);
        $this->assertEquals($categoryDescription, $response->description);
        $this->assertTrue($response->is_active);

        Mockery::close();
    }
}