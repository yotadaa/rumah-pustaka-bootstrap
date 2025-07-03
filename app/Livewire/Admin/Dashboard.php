<?php

namespace App\Livewire\Admin;

use App\Models\ChoosenIndikator;
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
    public $choosen_indikator;

    public $total_progress = 0;

    public $berkas;
    public function mount()
    {
        $berkas = Berkas::where('model', 'akreditasi')->get()->first();

        $this->choosen_indikator = ChoosenIndikator::where('berkas_id', $berkas->id)->get();
        // dd($berkas);
        $this->berkas = Berkas::where('model', 'akreditasi')->get();
        $this->berkas_id = $berkas->id;
        $this->berkas_label = $berkas->name;

        if (!$berkas) {
            $this->all_scores = 0;
            $this->grouped_scores = collect();
            return;
        }

        $aspekIds = Aspek::all()->pluck('id');
        $indikatorIds = Indikator::all()->pluck('id');

        $options = ChoosenIndikator::with('indikator.aspek.komponen')
            ->whereIn('indikator_id', $indikatorIds)
            ->get();
        // dd($aspekIds);

        $groupedByKomponen = $options->groupBy(function ($option) {
            return optional($option->indikator->aspek->komponen)->id;
        })->map(function ($group, $komponenId) {
            $komponen = Komponen::find($komponenId);
            $aspek_id = Aspek::where('komponen_id', $komponenId)->get()->pluck('id');
            $indikator_id = Indikator::whereIn('aspek_id', $aspek_id)->where('multiple', false)->pluck('id');
            $option_all = ChoosenIndikator::whereIn('indikator_id', $indikator_id)->where('berkas_id', $this->berkas_id)->get();

            return [
                'id' => $komponenId,
                'berkas_id' => $option_all ? $option_all->first()->berkas_id : null,
                'name' => $komponen->name ?? '-',
                'skor' => $group->where('berkas_id', $this->berkas_id)->sum('score'),
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
            $option_all = ChoosenIndikator::whereIn('indikator_id', $indikator_id)->where('berkas_id', $this->berkas_id)->get();
            // dd($option_all->first());

            return [
                'id' => $komponen->id,
                'berkas_id' => $option_all->first() != null ? $option_all->first()->berkas_id : null,
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
        // dd($groupedByKomponen);
        // dd($this->grouped_scores);
        if ($this->grouped_scores != null) {
            $this->grouped_scores->each(function ($o) {
                if ($o['indikator'] != 0)
                    $this->all_scores += $o['skor'] / $o['indikator'];
                else
                    $this->all_scores += 0;
            });
        }
        // dd($this->all_scores / 2);

        $this->total_progress = $this->choosen_indikator->count() / Indikator::all()->count();

        $this->total_progress = round($this->total_progress * 100, 2);
        // $this->updateVariabel();
    }


    public function updateVariabel()
    {
        $this->choosen_indikator = ChoosenIndikator::where('berkas_id', $this->berkas_id)->get();
        $this->total_progress = $this->choosen_indikator->count();
        $indikatorIds = Indikator::all()->pluck('id');

        $options = ChoosenIndikator::with('indikator.aspek.komponen')
            ->whereIn('indikator_id', $indikatorIds)
            ->get();
        // dd($aspekIds);

        $groupedByKomponen = $options->groupBy(function ($option) {
            return optional($option->indikator->aspek->komponen)->id;
        })->map(function ($group, $komponenId) {
            $komponen = Komponen::find($komponenId);
            $aspek_id = Aspek::where('komponen_id', $komponenId)->get()->pluck('id');
            $indikator_id = Indikator::whereIn('aspek_id', $aspek_id)->where('multiple', false)->pluck('id');
            $option_all = ChoosenIndikator::whereIn('indikator_id', $indikator_id)->where('berkas_id', $this->berkas_id)->get();
            // dd($indikator_id);
            return [
                'id' => $komponenId,
                'berkas_id' => $option_all->last() ? $option_all->last()->berkas_id : null,
                'name' => $komponen->name ?? '-',
                'skor' => $group->where('berkas_id', $this->berkas_id)->sum('score'),
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
            $option_all = ChoosenIndikator::whereIn('indikator_id', $indikator_id)->where('berkas_id', $this->berkas_id)->get();


            return [
                'id' => $komponen->id,
                'berkas_id' => $option_all->first() ? $option_all->first()->berkas_id : null,
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
        // dd($groupedByKomponen);
        // dd($this->grouped_scores);
        // dd($this->grouped_scores);
        if ($this->grouped_scores != null) {
            $this->grouped_scores->each(function ($o) {
                if ($o['indikator'] != 0)
                    $this->all_scores += $o['skor'] / $o['indikator'];
                else
                    $this->all_scores += 0;
            });
        }
    }

    public function changeBerkas($id)
    {
        // dd($id);    
        $this->dispatch('show-loading', loading: true);
        try {
            $this->total_progress = 0;
            $this->berkas_id = $id;
            $this->berkas_label = $this->berkas->where('id', $id)->first()->name;
            $this->updateVariabel();
            $this->total_progress = $this->choosen_indikator->count() / Indikator::all()->count();

            $this->total_progress = round($this->total_progress * 100, 2);
            $this->dispatch('show-loading', loading: false);
        } catch (\Exception $e) {
            $this->dispatch('show-loading', loading: false);
            $this->dispatch('show-toast', message: ['mode' => 'danger', 'message' => "Terjadi error: " . $e->getMessage()]);
        } finally {
            $this->dispatch('show-toast', message: ['mode' => 'success', 'message' => "Berhasil!"]);
            $this->dispatch('show-loading', loading: false);
        }
    }



    public function render()
    {


        $aspekIds = Aspek::where('berkas_id', $this->berkas_id)->pluck('id');
        $indikatorIds = Indikator::whereIn('aspek_id', $aspekIds)->pluck('id');

        $options = ChoosenIndikator::with('indikator.aspek.komponen')
            ->whereIn('indikator_id', $indikatorIds)
            ->where('berkas_id', $this->berkas_id)
            ->get();


        $groupedByKomponen = $options->groupBy(function ($option) {
            return optional($option->indikator->aspek->komponen)->id;
        })->map(function ($group, $komponenId) {
            $komponen = Komponen::find($komponenId);
            $aspek_id = Aspek::where('komponen_id', $komponenId)->get()->pluck('id');
            $indikator_id = Indikator::whereIn('aspek_id', $aspek_id)->where('multiple', false)->pluck('id');
            $option_all = ChoosenIndikator::whereIn('indikator_id', $indikator_id)->where('berkas_id', $this->berkas_id)->get();



            return [
                'id' => $komponenId,
                'berkas_id' => $option_all ? $option_all->first()->berkas_id : null,
                'name' => $komponen->name ?? '-',
                'skor' => $group->where('berkas_id', $this->berkas_id)->sum('score'),
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
            $option_all = ChoosenIndikator::whereIn('indikator_id', $indikator_id)->where('berkas_id', $this->berkas_id)->get();


            return [
                'id' => $komponen->id,
                'berkas_id' => $option_all->first() ? $option_all->first()->berkas_id : null,
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
        if ($this->grouped_scores != null) {
            $this->grouped_scores->each(function ($o) {
                if ($o['indikator'] != 0)
                    $this->all_scores += $o['skor'] / $o['indikator'];
                else
                    $this->all_scores += 0;
            });
        }
        return view('livewire.admin.dashboard');
    }
}
