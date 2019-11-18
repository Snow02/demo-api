<?php
namespace App\Repositories\Interfaces;
interface PostRepositoryInterface
{
    public function getListPostsTrashed();
    public function restorePostTrashed($id);
    public function getImages(object $post);
    public function getAvatar(object $post);
}