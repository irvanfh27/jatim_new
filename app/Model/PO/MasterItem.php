<?php

namespace App\Model\PO;

use Illuminate\Database\Eloquent\Model;

class MasterItem extends Model
{
    protected $table = 'master_item';
    protected $primaryKey = 'idmaster_item';
    protected $fillable = ['uuid', 'name', 'code', 'uom_id', 'group_item_id', 'created_by', 'updated_by'];
    protected $appends = ['uom_name','group_item_name'];

    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id', 'id_uom');
    }

    public function getUomNameAttribute()
    {
        return $this->uom->uom_type;
    }

    public function group_item()
    {
        return $this->belongsTo(MasterGroupItem::class, 'group_item_id', 'idmaster_groupitem');
    }

    public function getGroupItemNameAttribute()
    {
        return $this->group_item->name;
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
