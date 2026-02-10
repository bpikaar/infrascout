<?php

namespace Database\Seeders;

use App\Enums\MethodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MethodDescriptionsSeeder extends Seeder
{
    private array $descriptions = [
        [
            'method_type' => MethodType::RadioDetection->value,
            'method_name' => 'Radiodetectie',
            'description' => 'Opsporingsmethode waarbij met een zender en ontvanger metalen kabels of leidingen in de ondergrond worden gelokaliseerd. Het signaal wordt op de leiding gezet, waarna het tracé bovengronds wordt gevolgd. Tevens wordt een indicatie van de diepteligging bepaald. De fabrieksopgave van detectieapparatuur ligt doorgaans rond ±5% van de diepte onder ideale omstandigheden. In de praktijk kunnen afwijkingen groter zijn (circa ±0,1–0,3 m horizontaal en ±10–20% in diepte) door bodemgesteldheid, interferentie van andere objecten en signaalvervorming.',
        ],
        [
            'method_type' => MethodType::Gyroscope->value,
            'method_name' => 'Gyroscoopmeting',
            'description' => 'Meetmethode waarbij met een gyroscopische sonde het exacte 3D-verloop van een boring of leiding inwendig wordt gemeten. De methode is onafhankelijk van GPS en elektromagnetische invloeden. De diepteligging wordt bepaald uit het gemeten traject en is niet afhankelijk van bovengrondse detectie. Gyroscopische mapping behoort tot de meest nauwkeurige technieken voor tracébepaling, met afwijkingen doorgaans binnen enkele centimeters tot circa ±0,1 m, afhankelijk van trajectlengte en kalibratie.',
        ],
        [
            'method_type' => MethodType::TestTrench->value,
            'method_name' => 'Proefsleuf graven',
            'description' => 'Het plaatselijk open graven van de bodem om kabels en leidingen visueel waar te nemen. Geeft directe bevestiging van zowel tracé als diepteligging en geldt als referentiemethode. Meetonnauwkeurigheid is hierbij beperkt tot uitvoeringsmarges en afleesfouten en ligt praktisch op centimeterniveau.',
        ],
        [
            'method_type' => MethodType::GroundRadar->value,
            'method_name' => 'Grondradar (GPR – Ground Penetrating Radar)',
            'description' => 'Niet-destructieve techniek waarbij radarsignalen de bodem in worden gestuurd. Reflecties van objecten en bodemlagen worden gebruikt om tracé en diepte te bepalen. Onder ideale omstandigheden kan de horizontale nauwkeurigheid enkele centimeters bedragen. In de praktijk wordt rekening gehouden met ±0,05–0,20 m horizontaal en ±10–25% in diepte, afhankelijk van bodemtype, vochtgehalte en kalibratie.',
        ],
        [
            'method_type' => MethodType::CableFailure->value,
            'method_name' => 'Kabelstoring',
            'description' => 'Moet nog ingevuld worden.',
        ],

        [
            'method_type' => MethodType::GpsMeasurement->value,
            'method_name' => 'GPS inmeten (GNSS)',
            'description' => 'Wordt gebruikt om bovengrondse posities vast te leggen in coördinaten. Bij RTK-metingen bedraagt de nauwkeurigheid circa ±0,01–0,03 m horizontaal en ±0,02–0,05 m verticaal. Zonder RTK kan de afwijking oplopen tot meters.',
        ],
        [
            'method_type' => MethodType::Lance->value,
            'method_name' => 'Aanprikken met prikstok of spuitlans',
            'description' => 'Fysieke verificatiemethode waarbij voorzichtig wordt geprikt om de ligging te bevestigen. De positie kan tot enkele centimeters worden bepaald, situatie ter plaatse bepalen of deze techniek ingezet kan worden, zoals harde lagen en/of puin in de ondergrond.',
        ],

        // cable failure
        [
            'method_type' => MethodType::TDR->value,
            'method_name' => 'Kabelstoring lokaliseren met TDR (Megger 2050)',
            'description' => 'Met een Time Domain Reflectometer wordt een puls door de kabel gestuurd. Reflecties tonen de afstand tot de storing langs het kabeltracé. De nauwkeurigheid bedraagt doorgaans ±1% van de kabellengte (vaak ±0,5–2 m in de praktijk). De methode bepaalt geen diepte, alleen de lengtepositie.',
        ],
        [
            'method_type' => MethodType::AFrame->value,
            'method_name' => 'Kabelstoring opsporen met A-frame',
            'description' => 'Bij aardfouten wordt een foutstroom op de kabel gezet en het spanningsverschil in de bodem gemeten. De foutlocatie wordt doorgaans bepaald binnen ±0,1–0,5 m, afhankelijk van bodemgeleiding en foutsterkte. De diepteligging volgt uit de werkelijke ligging van de kabel.',
        ],
        [
            'method_type' => MethodType::Meggeren->value,
            'method_name' => 'Kabelstoring opsporen met radiodetectie',
            'description' => 'Het kabeltracé wordt gevolgd met een opgezet storingssignaal. Signaalveranderingen kunnen wijzen op de storingslocatie. De tracénauwkeurigheid is vergelijkbaar met standaard radiodetectie (±0,1–0,3 m). De storingslocatie is sterk afhankelijk van het type kabelstoring.',
        ],

        // radiodetection
        [
            'method_type' => MethodType::SignalSonde->value,
            'method_name' => 'Lokaliseren d.m.v. sondes',
            'description' => 'Een sonde wordt in een leiding of mantelbuis ingebracht en bovengronds gedetecteerd. Hiermee worden tracé en diepte-indicatie bepaald. Fabrieksmatig wordt vaak ±5% van de diepte opgegeven. In de praktijk wordt rekening gehouden met ±5-10% van de meetdiepte, afhankelijk van diepte en storende invloeden. De sonde moet fysiek toegang hebben tot de leiding of buis.',
        ],
        [
            'method_type' => MethodType::SignalGeleider->value,
            'method_name' => 'Lokaliseren d.m.v. geleider',
            'description' => 'Een geleider',
        ],

    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->descriptions as $description) {
            
            DB::table('method_descriptions')->insert(
                [
                    'method_type' => $description['method_type'],
                    'method_name' => $description['method_name'],
                    'description' => $description['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
