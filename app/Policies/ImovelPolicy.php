<?php

namespace FinxiImoveis\Policies;

use FinxiImoveis\User;
use FinxiImoveis\Entities\Imovel;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImovelPolicy
{
    use HandlesAuthorization;

    public function own(User $user, Imovel $imovel){
        return $user->owns($imovel);
    }
}
