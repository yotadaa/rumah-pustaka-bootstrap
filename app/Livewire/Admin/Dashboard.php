<?php

namespace App\Livewire\Admin;

use App\Models\Komponen;
use Livewire\Component;
use \App\Models\OpsiIndikator;
use \App\Models\Indikator;
use \App\Models\SubAspek;
use \App\Models\Aspek;
use \App\Models\Berkas;

class Dashboard extends Component
{

    public $all_scores = 0;
    public $grouped_scores;
    public $berkas_id = null, $berkas_label = "";

    public $total_progress = 0;

    public $berkas;
    public function mount()
    {
        $berkas = Berkas::where('model', 'akreditasi')->get()->last();
        // dd($berkas);
        $this->berkas = Berkas::where('model', 'akreditasi')->get();
        $this->berkas_id = $berkas->id;
        $this->berkas_label = $berkas->name;

        if (!$berkas) {
            $this->all_scores = 0;
            $this->grouped_scores = collect();
            return;
        }

        $aspekIds = Aspek::where('berkas_id', $this->berkas_id)->pluck('id');
        $indikatorIds = Indikator::whereIn('aspek_id', $aspekIds)->pluck('id');

        $options = OpsiIndikator::with('indikator.aspek.komponen')
            ->whereIn('indikator_id', $indikatorIds)
            ->where('choosen', true)
            ->get();


        $groupedByKomponen = $options->groupBy(function ($option) {
            return optional($option->indikator->aspek->komponen)->id;
        })->map(function ($group, $komponenId) {
            $komponen = Komponen::find($komponenId);
            $aspek_id = Aspek::where('komponen_id', $komponenId)->get()->pluck('id');
            $indikator_id = Indikator::whereIn('aspek_id', $aspek_id)->where('multiple', false)->pluck('id');
            $option_all = OpsiIndikator::whereIn('indikator_id', $indikator_id)->where('choosen', true)->get();

            return [
                'id' => $komponenId,
                'name' => $komponen->name ?? '-',
                'skor' => $group->sum('score'),
                'maksimum_skor' => $komponen->skor,
                'indikator' => count($indikator_id),
                'filled' => $option_all->count(),
                // 'choosen' => $grou
            ];
        });
        $other_komponen = Komponen::whereNotIn('id', $groupedByKomponen->values()->pluck('id'))->where('model', 'akreditasi')->get();
        $otherMapped = $other_komponen->map(function ($komponen) {
            $indikatorCount = $komponen->aspek->flatMap->indikator->count();
            $komponen = Komponen::find($komponen->id);
            $aspek_id = Aspek::where('komponen_id', $komponen->id)->get()->pluck('id');
            $indikator_id = Indikator::whereIn('aspek_id', $aspek_id)->where('multiple', false)->pluck('id');
            $option_all = OpsiIndikator::whereIn('indikator_id', $indikator_id)->where('choosen', true)->get();
            return [
                'id' => $komponen->id,
                'name' => $komponen->name,
                'skor' => 0,
                'maksimum_skor' => $komponen->skor,
                'indikator' => count($indikator_id),
                'filled' => $option_all->count(),
            ];
        });
        // dd($otherMapped);
        if ($groupedByKomponen->values()->count() == 0) {
            $this->groupedScores = $otherMapped->values();
        } else {
            $this->grouped_scores = $groupedByKomponen->values()->merge($otherMapped);
        }
        // dd($this->grouped_scores);
        $this->grouped_scores->each(function ($o) {
            if ($o['indikator'] != 0)
                $this->all_scores += $o['skor'] / $o['indikator'];
            else
                $this->all_scores += 0;
        });

        // dd($this->all_scores / 2);

        $this->grouped_scores->each(function ($o) {
            $this->total_progress += ($o['skor'] / $o['maksimum_skor'] * $o['indikator']) / $o['maksimum_skor'];
        });

        $this->total_progress /= \App\Models\Komponen::where('model', 'akreditasi')->count();
        $this->total_progress = round($this->total_progress * 100, 2);
    }


    public function changeBerkas($id)
    {
        $this->berkas_id = $id;
        $this->berkas_label = $this->berkas->where('id', $id)->first()->name;
    }



    public function render()
    {
        $aspekIds = Aspek::where('berkas_id', $this->berkas_id)->pluck('id');
        $indikatorIds = Indikator::whereIn('aspek_id', $aspekIds)->pluck('id');

        $options = OpsiIndikator::with('indikator.aspek.komponen')
            ->whereIn('indikator_id', $indikatorIds)
            ->where('choosen', true)
            ->get();


        $groupedByKomponen = $options->groupBy(function ($option) {
            return optional($option->indikator->aspek->komponen)->id;
        })->map(function ($group, $komponenId) {
            $komponen = Komponen::find($komponenId);
            $aspek_id = Aspek::where('komponen_id', $komponenId)->get()->pluck('id');
            $indikator_id = Indikator::whereIn('aspek_id', $aspek_id)->where('multiple', false)->pluck('id');
            $option_all = OpsiIndikator::whereIn('indikator_id', $indikator_id)->where('choosen', true)->get();

            return [
                'id' => $komponenId,
                'name' => $komponen->name ?? '-',
                'skor' => $group->sum('score'),
                'maksimum_skor' => $komponen->skor,
                'indikator' => count($indikator_id),
                'filled' => $option_all->count(),
                // 'choosen' => $grou
            ];
        });
        $other_komponen = Komponen::whereNotIn('id', $groupedByKomponen->values()->pluck('id'))->where('model', 'akreditasi')->get();
        $otherMapped = $other_komponen->map(function ($komponen) {
            $indikatorCount = $komponen->aspek->flatMap->indikator->count();
            $komponen = Komponen::find($komponen->id);
            $aspek_id = Aspek::where('komponen_id', $komponen->id)->get()->pluck('id');
            $indikator_id = Indikator::whereIn('aspek_id', $aspek_id)->where('multiple', false)->pluck('id');
            $option_all = OpsiIndikator::whereIn('indikator_id', $indikator_id)->where('choosen', true)->get();
            return [
                'id' => $komponen->id,
                'name' => $komponen->name,
                'skor' => 0,
                'maksimum_skor' => $komponen->skor,
                'indikator' => count($indikator_id),
                'filled' => $option_all->count(),
            ];
        });
        // dd($otherMapped);
        if ($groupedByKomponen->values()->count() == 0) {
            $this->groupedScores = $otherMapped->values();
        } else {
            $this->grouped_scores = $groupedByKomponen->values()->merge($otherMapped);
        }
        // dd($this->grouped_scores);
        $this->grouped_scores->each(function ($o) {
            if ($o['indikator'] != 0)
                $this->all_scores += $o['skor'] / $o['indikator'];
            else
                $this->all_scores += 0;
        });

        return view('livewire.admin.dashboard');
    }
}
