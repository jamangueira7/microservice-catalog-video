<?php


namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Entity\PaginateInterface;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategoriesInputDto;
use Core\UseCase\DTO\Category\ListCategoriesOutputDto;
use \PHPUnit\Framework\TestCase;
use Mockery;
use stdClass;
use Core\Domain\Entity\CategoryRepositoryInterface;

class ListCategoriesUseCaseUnitTest extends TestCase
{
    public function testListCategoriesEmpty()
    {
        $mockPaginate = $this->mockPaginate();

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('paginate')
            ->times(1)
            ->andReturn($mockPaginate);


        $this->mockDTO = Mockery::mock(ListCategoriesInputDto::class, [
            'filter', 'desc'
        ]);

        $useCase = new ListCategoriesUseCase($this->mockRepository);
        $response = $useCase->execute($this->mockDTO);

        $this->assertCount(0, $response->items);
        $this->assertInstanceOf(ListCategoriesOutputDto::class, $response);

    }

    public function testListCategories()
    {
        $register = new stdClass();
        $register->id = 'sfd';
        $register->name = 'name';
        $register->description = 'description';
        $register->create_at = 'create_at';

        $mockPaginate = $this->mockPaginate([
            $register
        ]);

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('paginate')
            ->times(1)
            ->andReturn($mockPaginate);


        $this->mockDTO = Mockery::mock(ListCategoriesInputDto::class, [
            'filter', 'desc'
        ]);

        $useCase = new ListCategoriesUseCase($this->mockRepository);
        $response = $useCase->execute($this->mockDTO);

        $this->assertCount(1, $response->items);
        $this->assertInstanceOf(stdClass::class, $response->items[0]);
        $this->assertInstanceOf(ListCategoriesOutputDto::class, $response);
    }

    protected function mockPaginate(array $items = [])
    {
        $this->mockPaginate = Mockery::mock(stdClass::class, PaginateInterface::class);
        $this->mockPaginate->shouldReceive('items')->andReturn($items);
        $this->mockPaginate->shouldReceive('total')->andReturn(0);
        $this->mockPaginate->shouldReceive('lastPage')->andReturn(0);
        $this->mockPaginate->shouldReceive('firstPage')->andReturn(0);
        $this->mockPaginate->shouldReceive('currentPage')->andReturn(0);
        $this->mockPaginate->shouldReceive('perPage')->andReturn(0);
        $this->mockPaginate->shouldReceive('to')->andReturn(0);
        $this->mockPaginate->shouldReceive('from')->andReturn(0);

        return $this->mockPaginate;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}