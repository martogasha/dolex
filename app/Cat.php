<?php

namespace App;


use http\Env\Request;

class Cat
{
   public $item = null;
   public $totalQty = 0;
   public $totalPrice = 0;

   public function __construct($oldCart)
   {
       if ($oldCart) {
           $this->item = $oldCart->item;
           $this->totalQty = $oldCart->totalQty;
           $this->totalPrice = $oldCart->totalPrice;


       }
   }
       public function add($item, $id)
       {
           $storedItem = ['quantity' => 0, 'amount' => $item->price, 'item' => $item];
           if ($this->item) {
               if (array_key_exists($id, $this->item)) {
                   $storedItem = $this->item[$id];
               }
           }
           $storedItem['quantity']++;
           $storedItem['amount'] = $item->amount * $storedItem['quantity'];
           $this->item[$id] = $storedItem;
           $this->totalQty++;
           $this->totalPrice += $item->amount;
   }
    public function addByOne($id){
        $this->item[$id]['quantity']++;
        $this->item[$id]['amount'] += $this->item[$id]['item']['amount'];
        $this->totalQty++;
        $this->totalPrice += $this->item[$id]['item']['amount'];
        if ($this->item[$id]['quantity'] <= 0){
            unset($this->item[$id]);
        }
    }
   public function reduceByOne($id){
       $this->item[$id]['quantity']--;
       $this->item[$id]['amount'] -= $this->item[$id]['item']['amount'];
       $this->totalQty--;
       $this->totalPrice -= $this->item[$id]['item']['amount'];
       if ($this->item[$id]['quantity'] <= 0){
           unset($this->item[$id]);
       }
   }
   public function removeItem($id){
       $this->totalQty -= $this->item[$id]['quantity'];
       $this->totalPrice -= $this->item[$id]['amount'];
       unset($this->item[$id]);
   }


}
