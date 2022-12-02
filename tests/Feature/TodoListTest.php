<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private mixed $list;

    public function setUp(): void
    {
        parent::setUp();
        $this->list = TodoList::factory()->create();
    }

    public function test_fetch_all_todo_list()
    {
        $response = $this->getJson(route('todo-list.index'));

        $this->assertCount(1, $response->json());
    }

    public function test_fetch_single_todo_List()
    {
        $response = $this->getJson(route('todo-list.show', $this->list->id))
            ->assertOk()
            ->json();

        $this->assertEquals($response['name'], $this->list->name);
    }

    public function test_store_new_todo_list()
    {
        $list = ['name' => 'test list'];
        $response = $this->postJson(route('todo-list.store'), $list)
            ->assertCreated()
            ->json();

        $this->assertEquals('test list', $response['name']);
        $this->assertDatabaseHas('todo_lists', $list);
    }

    public function test_while_storing_todo_list_name_field_is_required()
    {
        $this->withExceptionHandling();

        $this->postJson(route('todo-list.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }
}
