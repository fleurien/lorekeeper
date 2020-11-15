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
}