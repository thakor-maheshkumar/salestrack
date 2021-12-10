<?php

namespace App\Services;

use Sentinel;

class Slug
{
    /**
     * create slug for role
     *
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function createSlug($title, $table, $field = 'slug', $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title, '_');

        $allSlugs = $this->getRelatedSlugs($slug, $table, $field, $id);

        if (! $allSlugs->contains($field, $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains($field, $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    /**
     * Check for slug existance
     *
     * @param $slug
     * @param int $id
     * @return string
     * @throws \Exception
     */
    protected function getRelatedSlugs($slug, $table, $field = 'slug', $id = 0)
    {
        //return Sentinel::getRoleRepository()->where('slug', 'like', $slug.'%')->where('id', '<>', $id)->get();

        return \DB::table($table)->where($field, 'like', $slug.'%')->where('id', '<>', $id)->get();
    }
}