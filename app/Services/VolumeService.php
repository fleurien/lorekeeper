<?php namespace App\Services;

use Carbon\Carbon;
use App\Services\Service;

use DB;
use Notifications;
use Config;

use App\Models\User\User;
use App\Models\User\UserItem;
use App\Models\User\UserVolume;

use App\Models\Volume\Volume;
use App\Models\Volume\Book;

use App\Services\InventoryManager;

class VolumeService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Volume Service
    |--------------------------------------------------------------------------
    |
    | Handles the creation and editing of volumes.
    |
    */

    /**********************************************************************************************
     
        VolumeS
    **********************************************************************************************/

    /**
     * Creates a new volume.
     *
     * @param  array                  $data 
     * @param  \App\Models\User\User  $user
     * @return bool|\App\Models\Volume\Volume
     */
    public function createVolume($data, $user)
    {
        DB::beginTransaction();

        try {

            if(isset($data['book_id']) && $data['book_id'] == 'none') $data['book_id'] = null;
            if((isset($data['book_id']) && $data['book_id']) && !Book::where('id', $data['book_id'])->exists()) throw new \Exception("The selected ".__('volumes.book')." is invalid.");

            $data = $this->populateData($data);

            $image = null;
            if(isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image = $data['image'];
                unset($data['image']);
            }
            else $data['has_image'] = 0;


            $volume = Volume::create($data);
            $volume->save();

            if ($image) $this->handleImage($image, $volume->imagePath, $volume->imageFileName);

            return $this->commitReturn($volume);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates an volume.
     *
     * @param  \App\Models\Volume\Volume  $volume
     * @param  array                  $data 
     * @param  \App\Models\User\User  $user
     * @return bool|\App\Models\Volume\Volume
     */
    public function updateVolume($volume, $data, $user)
    {
        DB::beginTransaction();

        try {

            if(isset($data['book_id']) && $data['book_id'] == 'none') $data['book_id'] = null;
            // More specific validation
            if(Volume::where('name', $data['name'])->where('id', '!=', $volume->id)->exists()) throw new \Exception("The name has already been taken.");
            if((isset($data['book_id']) && $data['book_id']) && !Book::where('id', $data['book_id'])->exists()) throw new \Exception("The selected ".__('volumes.book')." is invalid.");


            $data = $this->populateData($data);

            $image = null;            
            if(isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image = $data['image'];
                unset($data['image']);
            }

            $volume->update($data);
            $volume->save();

            if ($volume) $this->handleImage($image, $volume->imagePath, $volume->imageFileName);

            return $this->commitReturn($volume);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Processes user input for creating/updating an volume.
     *
     * @param  array                  $data 
     * @param  \App\Models\Volume\Volume  $volume
     * @return array
     */
    private function populateData($data, $volume = null)
    {
        if(isset($data['description']) && $data['description']) $data['parsed_description'] = parse($data['description']);

        if(isset($data['remove_image']))
        {
            if($volume && $volume->has_image && $data['remove_image']) 
            { 
                $data['has_image'] = 0; 
                $this->deleteImage($volume->imagePath, $volume->imageFileName); 
            }
            unset($data['remove_image']);
        }

        if(!isset($data['is_visible'])) $data['is_visible'] = 0;

        if(!isset($data['is_global'])) $data['is_global'] = 0;

        return $data;
    }



    /**
     * Deletes an volume.
     *
     * @param  \App\Models\Volume\Volume  $volume
     * @return bool
     */
    public function deleteVolume($volume)
    {
        DB::beginTransaction();

        try {
            // Check first if the volume is currently owned or if some other site feature uses it
            if(DB::table('user_volumes')->where('volume_id', $volume->id)->exists()) throw new \Exception("At least one user currently owns this ".__('volumes.volume').". Please remove the ".__('volumes.volumes')." before deleting it.");

            DB::table('user_volumes_log')->where('volume_id', $volume->id)->delete();
            DB::table('user_volumes')->where('volume_id', $volume->id)->delete();
            if($volume->has_image) $this->deleteImage($volume->imagePath, $volume->imageFileName); 
            $volume->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }




    /**********************************************************************************************
        Books
    **********************************************************************************************/

    /**
     * Create a book.
     *
     * @param  array                 $data
     * @param  \App\Models\User\User $user
     * @return \App\Models\Volume\Book|bool
     */
    public function createBook($data, $user)
    {
        DB::beginTransaction();

        try {

            $data = $this->populateBookData($data);

            $image = null;
            if(isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image = $data['image'];
                unset($data['image']);
            }
            else $data['has_image'] = 0;

            $book = Book::create($data);

            if ($image) $this->handleImage($image, $book->imagePath, $book->imageFileName);

            return $this->commitReturn($book);
        } catch(\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Update a book.
     *
     * @param  \App\Models\Volume\Book  $book
     * @param  array                          $data
     * @param  \App\Models\User\User          $user
     * @return \App\Models\Volume\Book|bool
     */
    public function updateBook($book, $data, $user)
    {
        DB::beginTransaction();

        try {
            // More specific validation
            if(Book::where('name', $data['name'])->where('id', '!=', $book->id)->exists()) throw new \Exception("The name has already been taken.");

            $data = $this->populateBookData($data, $book);

            $image = null;
            if(isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image = $data['image'];
                unset($data['image']);
            }

            $book->update($data);

            if ($book) $this->handleImage($image, $book->imagePath, $book->imageFileName);

            return $this->commitReturn($book);
        } catch(\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Handle book data.
     *
     * @param  array                               $data
     * @param  \App\Models\Volume\Book|null  $book
     * @return array
     */
    private function populateBookData($data, $book = null)
    {

        if(isset($data['description']) && $data['description']) $data['parsed_description'] = parse($data['description']);
        
        if(isset($data['remove_image']))
        {
            if($book && $book->has_image && $data['remove_image'])
            {
                $data['has_image'] = 0;
                $this->deleteImage($book->imagePath, $book->imageFileName);
            }
            unset($data['remove_image']);
        }

        if(!isset($data['is_visible'])) $data['is_visible'] = 0;

        return $data;
    }

    /**
     * Delete a book.
     *
     * @param  \App\Models\Volume\Book  $book
     * @return bool
     */
    public function deleteBook($book)
    {
        DB::beginTransaction();

        try {
            // Check first if the book is currently in use
            if(Volume::where('book_id', $book->id)->exists()) throw new \Exception("A ".__('volumes.volume')." with this ".__('volumes.book')." exists. Please change its ".__('volumes.book')." first.");

            if($book->has_image) $this->deleteImage($book->imagePath, $book->imageFileName);
            $book->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}

