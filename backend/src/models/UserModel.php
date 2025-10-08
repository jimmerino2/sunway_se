<?php

class UserModel {
    private $users = [
        ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
        ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com']
    ];

    public function getAll() {
        return $this->users;
    }

    public function find($id) {
        foreach ($this->users as $user) {
            if ($user['id'] == $id) return $user;
        }
        return null;
    }

    public function create($data) {
        $data['id'] = rand(100, 999);
        $this->users[] = $data;
        return $data;
    }

    public function update($id, $data) {
        foreach ($this->users as &$user) {
            if ($user['id'] == $id) {
                $user = array_merge($user, $data);
                return true;
            }
        }
        return false;
    }

    public function delete($id) {
        foreach ($this->users as $key => $user) {
            if ($user['id'] == $id) {
                unset($this->users[$key]);
                return true;
            }
        }
        return false;
    }
}
