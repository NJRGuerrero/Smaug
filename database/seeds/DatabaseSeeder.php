<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Periodicity;
use App\Models\MovementType;
use App\Models\Currency;
use App\Models\AccountType;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p1 = new Periodicity();
        $p1->name = 'Diario';
        $p1->time_period = 'day';
        $p1->time_duration = 1;
        $p1->save();
        
        $p2 = new Periodicity();
        $p2->name = 'Cada Tercer día';
        $p2->time_period = 'day';
        $p2->time_duration = 2;
        $p2->save();
        
        $p3 = new Periodicity();
        $p3->name = 'Semanal';
        $p3->time_period = 'day';
        $p3->time_duration = 7;
        $p3->save();
        
        $p4 = new Periodicity();
        $p4->name = 'Quincenal';
        $p4->time_period = 'day';
        $p4->time_duration = 15;
        $p4->save();
        
        $p5 = new Periodicity();
        $p5->name = 'Mensual';
        $p5->time_period = 'month';
        $p5->time_duration = 1;
        $p5->save();
        
        $p6 = new Periodicity();
        $p6->name = 'Bimestral';
        $p6->time_period = 'month';
        $p6->time_duration = 2;
        $p6->save();
        
        $p7 = new Periodicity();
        $p7->name = 'Trimestral';
        $p7->time_period = 'month';
        $p7->time_duration = 3;
        $p7->save();
        
        $p8 = new Periodicity();
        $p8->name = 'Cuatrimestral';
        $p8->time_period = 'month';
        $p8->time_duration = 4;
        $p8->save();
        
        $p9 = new Periodicity();
        $p9->name = 'Semestral';
        $p9->time_period = 'month';
        $p9->time_duration = 6;
        $p9->save();
        
        $p10 = new Periodicity();
        $p10->name = 'Anual';
        $p10->time_period = 'year';
        $p10->time_duration = 1;
        $p10->save();
        
        $p11 = new Periodicity();
        $p11->name = 'Bianual';
        $p11->time_period = 'year';
        $p11->time_duration = 2;
        $p11->save();
        
        $p12 = new Periodicity();
        $p12->name = 'Trianual';
        $p12->time_period = 'year';
        $p12->time_duration = 3;
        $p12->save();
        
        $p13 = new Periodicity();
        $p13->name = 'Unico';
        $p13->time_period = 'none';
        $p13->time_duration = 0;
        $p13->save();
        
        $mt1 = new MovementType();
        $mt1->name = 'Ingreso';
        $mt1->save();
        
        $mt2 = new MovementType();
        $mt2->name = 'Egreso';
        $mt2->save();
        
        $mt3 = new MovementType();
        $mt3->name = 'Traspaso';
        $mt3->save();
        
        $c1 = new Currency();
        $c1->name = 'Peso';
        $c1->code = 'MXN';
        $c1->symbol = '$';
        $c1->save();
        
        $c2 = new Currency();
        $c2->name = 'Dolar';
        $c2->code = 'USD';
        $c2->symbol = '$';
        $c2->save();
        
        $c3 = new Currency();
        $c3->name = 'Euro';
        $c3->code = 'EUR';
        $c3->symbol = '€';
        $c3->save();
        
        $ac1 = new AccountType();
        $ac1->name = 'Nomina';
        $ac1->save();
        
        $ac2 = new AccountType();
        $ac2->name = 'Ahorro';
        $ac2->save();
        
        $ac3 = new AccountType();
        $ac3->name = 'Efectivo';
        $ac3->save();
        
        $ac4 = new AccountType();
        $ac4->name = 'Inversión';
        $ac4->save();
        
        $ac5 = new AccountType();
        $ac5->name = 'Crédito';
        $ac5->save();
        
        $ac6 = new AccountType();
        $ac6->name = 'Otro';
        $ac6->save();
        
        $u = new User();
        $u->name = 'NJRGuerrero';
        $u->email = 'nestor.jr.guerrero@gmail.com';
        $u->password = password_hash('637754837', PASSWORD_BCRYPT);
        $u->currency_id = 1;
        $u->save();
    }
}
