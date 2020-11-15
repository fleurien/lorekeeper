<?php namespace App\Services;

use App\Services\Service;

use DB;
use Config;

use App\Models\Product;

class ProductService extends Service
{
    /**
     * Creates a new product.
     *
     * @param  array                  $data 
     * @param  \App\Models\User\User  $user
     * @return bool|\App\Models\Product
     */
    public function createProduct($data, $user)
    {
        DB::beginTransaction();

        try {

            if(Product::where('item_id', $data['item_id'])->exists()) throw new \Exception("This item is already in stock.");

            if(!isset($data['is_visible'])) $data['is_visible'] = 0;
            if(!isset($data['is_limited'])) $data['is_limited'] = 0;
            if(!isset($data['is_bundle'])) $data['is_bundle'] = 0;

            $product = Product::create($data);

            return $this->commitReturn($product);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates a product.
     *
     * @param  \App\Models\Product  $product
     * @param  array                  $data 
     * @param  \App\Models\User\User  $user
     * @return bool|\App\Models\Product
     */
    public function updateProduct($product, $data, $user)
    {
        DB::beginTransaction();

        try {
            if(!isset($data['is_visible'])) $data['is_visible'] = 0;
            if(!isset($data['is_limited'])) $data['is_limited'] = 0;
            if(!isset($data['is_bundle'])) $data['is_bundle'] = 0;

            // More specific validation
            if(Product::where('item_id', $data['item_id'])->where('id', '!=', $product->id)->exists()) throw new \Exception("This item is already in stock.");

            $product->update($data);

            return $this->commitReturn($product);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
    
    /**
     * Deletes an product.
     *
     * @param  \App\Models\Product
     * @return bool
     */
    public function deleteProduct($product)
    {
        DB::beginTransaction();

        try {
            // make sure no one is in progress buying sort of deal

            if($product->is_visible == 1) throw new \Exception("This product is currently buyable. Please hide it first.");
        
            $product->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
    
    /**********************************************************************************************
     
        ITEM TAGS

    **********************************************************************************************/
    
    /**
     * Gets a list of item tags for selection.
     *
     * @return array
     */
    public function getItemTags()
    {
        $tags = Config::get('lorekeeper.item_tags');
        $result = [];
        foreach($tags as $tag => $tagData)
            $result[$tag] = $tagData['name'];

        return $result;
    }
    
    /**
     * Adds an item tag to an item.
     *
     * @param  \App\Models\Item\Item  $item
     * @param  string                 $tag
     * @return string|bool
     */
    public function addItemTag($item, $tag)
    {
        DB::beginTransaction();

        try {
            if(!$item) throw new \Exception("Invalid item selected.");
            if($item->tags()->where('tag', $tag)->exists()) throw new \Exception("This item already has this tag attached to it.");
            if(!$tag) throw new \Exception("No tag selected.");
            
            $tag = ItemTag::create([
                'item_id' => $item->id,
                'tag' => $tag
            ]);

            return $this->commitReturn($tag);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
    
    /**
     * Edits the data associated with an item tag on an item.
     *
     * @param  \App\Models\Item\Item  $item
     * @param  string                 $tag
     * @param  array                  $data
     * @return string|bool
     */
    public function editItemTag($item, $tag, $data)
    {
        DB::beginTransaction();

        try {
            if(!$item) throw new \Exception("Invalid item selected.");
            if(!$item->tags()->where('tag', $tag)->exists()) throw new \Exception("This item does not have this tag attached to it.");
            
            $tag = $item->tags()->where('tag', $tag)->first();

            $service = $tag->service;
            if(!$service->updateData($tag, $data)) {
                $this->setErrors($service->errors());
                throw new \Exception('sdlfk');
            }

            // Update the tag's active setting
            $tag->is_active = isset($data['is_active']);
            $tag->save();

            return $this->commitReturn($tag);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
    
    /**
     * Removes an item tag from an item.
     *
     * @param  \App\Models\Item\Item  $item
     * @param  string                 $tag
     * @return string|bool
     */
    public function deleteItemTag($item, $tag)
    {
        DB::beginTransaction();

        try {
            if(!$item) throw new \Exception("Invalid item selected.");
            if(!$item->tags()->where('tag', $tag)->exists()) throw new \Exception("This item does not have this tag attached to it.");
            
            $item->tags()->where('tag', $tag)->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}