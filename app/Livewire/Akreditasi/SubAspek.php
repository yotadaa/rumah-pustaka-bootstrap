<?php

namespace App\Livewire\Akreditasi;

use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Aspek as AspekModel;
use App\Models\SubAspek as SubAspekModel;
use App\Models\Indikator;
use App\Models\OpsiIndikator;
use Illuminate\Support\Facades\Log;


class SubAspek extends Component
{


    public $is_processing = false;

    public $indikator_id, $aspek_id, $komponen_id, $berkas_id, $aspek;
    public $showForm = false;
    public $formName;
    public $modal;

    public $total_skor = 0;

    ## sub aspeks
    public $sub_aspeks, $sub_aspek_id, $sub_aspek_name, $delete_sub, $confirm_delete_sub;
    public $sub_edit, $sub_edit_name;


    ### indikator
    public $indikator_konten, $indikator_a, $indikator_b, $indikator_c, $indikator_d, $indikator_e, $indikator_multi = false, $indikator_sub;
    public $indikator, $indikator_option, $ind_id;
    public $label_edit_aspek, $label_edit_sub_aspek, $edit_aspek_id, $edit_sub_aspek_id, $label_edit_indikator, $edit_indikator_id;
    public $edit_indikator_content;

    public function mount($aspek_id, $komponen_id, $berkas_id)
    {
        $this->aspek_id = $aspek_id;
        $this->komponen_id = $komponen_id;
        $this->berkas_id = $berkas_id;
        $get_score = OpsiIndikator::where('choosen', true)->get();
        $get_score = $get_score->filter(function ($opsi) {
            return $opsi->indikator->aspek_id == $this->aspek_id;
        });

        if (count($get_score) != 0) {
            $this->total_skor = $get_score->sum('score') / count($get_score);
        }
    }

    public function toggleModal($modal_key, $close = false, $condition = "normal", $id = null, $ind_id = null)
    {

        $this->edit_aspek_id = $this->aspek_id;
        $this->modal = $modal_key;
        $this->dispatch('showModal');
        if ($close) {
            $this->modal = null;
            $this->edit_aspek_id = null;
            $this->edit_sub_aspek_id = null;
            $this->label_edit_aspek = null;
            $this->label_edit_sub_aspek = null;
            $this->indikator_konten = null;
            $this->indikator_a = null;
            $this->indikator_b = null;
            $this->indikator_c = null;
            $this->indikator_d = null;
            $this->indikator_e = null;
            $this->indikator_multi = false;
        }
        if ($condition == "del") {
            if ($this->delete_sub != null) {
                $this->delete_sub = null;
            }

            $this->delete_sub = SubAspekModel::findOrFail($id);
            logger($this->delete_sub);
        } else if ($condition == "edit") {
            $this->sub_edit = SubAspekModel::findOrFail($id);
            $this->sub_aspek_name = $this->sub_edit->name;
        }

        if ($this->indikator_sub == null) {
            $this->indikator_sub = $id;
        } else {
            $this->indikator_sub = null;
        }

        if ($ind_id != null) {
            $this->ind_id = $ind_id;
            // logger($ind_id);
            // dd($ind_id);
        } else {
            $this->ind_id = null;

        }
        if ($condition == "sub-soal") {
            $this->ind_id = $ind_id;
        }

        if ($condition == "edit-indikator") {
            $ind_ = Indikator::findOrFail($ind_id);
            // dd($ind_->sub_id);
            $asp_ = AspekModel::findOrFail($ind_->aspek_id);
            $this->label_edit_aspek = $asp_->name;
            if ($ind_->sub_aspek_id != null) {
                $sub_ = SubAspekModel::findOrFail($ind_->sub_aspek_id);
                $this->label_edit_sub_aspek = $sub_->name;
                $this->edit_sub_aspek_id = $sub_->id;
            }
            if ($ind_->sub_id != null) {
                $sub_content = Indikator::findOrFail($ind_->sub_id);
                $this->label_edit_indikator = $sub_content->content;
            } else {
                $this->label_edit_indikator = "Pilih indikator";
            }
            $this->edit_indikator_content = $ind_->content;
            $option = \App\Models\OpsiIndikator::where('indikator_id', $ind_id)->get();
            if (!$ind_->multiple) {
                $this->indikator_a = $option[0]->konten;
                $this->indikator_b = $option[1]->konten;
                $this->indikator_c = $option[2]->konten;
                $this->indikator_d = $option[3]->konten;
                $this->indikator_e = $option[4]->konten;
            }
            // dd($this->edit_indikator_content);
        }
        // $this->dispatch('refresh-page');
    }

    public function chooseAspekEdit($aspek_id)
    {
        // dd($this->ind_id);
        // $ind = Indikator::findOrFail($this->ind_id);
        $asp_ = AspekModel::findOrFail($aspek_id);
        $this->edit_aspek_id = $asp_->id;
        $this->label_edit_aspek = $asp_->name;
    }

    public function chooseSubAspekEdit($sub_aspek_id)
    {
        // dd($this->ind_id);
        // $ind = Indikator::findOrFail($this->ind_id);
        // if ($ind->sub_aspek_id != null) {

        if ($sub_aspek_id == null) {
            $this->edit_sub_aspek_id = null;
            $this->label_edit_sub_aspek = "Tanpa kategori";
            return;
        }
        $sub_ = SubAspekModel::findOrFail($sub_aspek_id);
        $this->edit_sub_aspek_id = $sub_->id;
        $this->label_edit_sub_aspek = $sub_->name;
    }

    public function chooseIndikatorEdit($indikator_id)
    {
        if ($indikator_id == null) {
            $this->edit_indikator_id = null;
            $this->label_edit_indikator = "Tanpa sub indikator";
            return;
        }
        $ind_ = Indikator::findOrFail($indikator_id);
        $this->edit_indikator_id = $ind_->id;
        $this->label_edit_indikator = $ind_->content;

    }

    public function move_indikator($ind_id, $step)
    {
        $current_indikator = Indikator::findOrFail($ind_id);

        if ($current_indikator->sub_id != null) {
            session()->flash('error', 'Indikator tidak dapat dipindahkan.');
            return;
        }
        $all_indicator = Indikator::where('aspek_id', $current_indikator->aspek_id)
            ->where('sub_aspek_id', $current_indikator->sub_aspek_id)
            ->where('sub_id', null)
            ->orderBy('no')
            ->get();

        $min_number = $all_indicator->min('no');
        $max_number = $all_indicator->max('no');
        $next_indikator = $all_indicator->firstWhere('no', $current_indikator->no + $step);


        if ($next_indikator == null) {
            session()->flash('error', 'Indikator tidak dapat dipindahkan.');
            return;
        }
        if ($step == -1 && $current_indikator->no == $min_number) {
            session()->flash('error', 'Indikator tidak dapat dipindahkan.');
            return;
        }
        if ($step == 1 && $current_indikator->no == $max_number) {
            session()->flash('error', 'Indikator tidak dapat dipindahkan.');
            return;
        }

        $temp = $current_indikator->no;
        $current_indikator->no = $next_indikator->no;
        $next_indikator->no = $temp;
        $current_indikator->save();
        $next_indikator->save();


        // dd($current_indikator->no, $min_number, $max_number);
        // dd([
        //     $all_indicator->min('no'),
        //     $all_indicator->max(callback: 'no'),
        //     $next_indikator->no
        // ]);

        session()->flash('success', 'Indikator berhasil dipindahkan.');
        $this->toggleModal("none", true);
        $this->is_processing = false;
    }


    public function confirm_indikator_edit()
    {
        if ($this->is_processing)
            return;
        $this->is_processing = true;
        $current_indikator = Indikator::findOrFail($this->ind_id);
        if ($this->edit_aspek_id == $this->aspek_id) {
            if ($this->edit_indikator_id == null) {
                $current_indikator->sub_id = null;
                // dd($current_indikator);
                $nextNumber = Indikator::where([
                    "sub_aspek_id" => $this->edit_sub_aspek_id,
                    "sub_id" => null
                ])->orderBy('no')->max('no');
                // dd($nextNumber);


                if ($nextNumber == null) {
                    $fix_number = Indikator::where([
                        "aspek_id" => $this->edit_aspek_id,
                        "sub_id" => null
                    ])->orderBy('no')->max('no');
                    $nextNumber += $fix_number;
                }
                $targetNo = $nextNumber;
                if ($this->edit_sub_aspek_id != $current_indikator->sub_aspek_id) {
                    if ($targetNo >= $current_indikator->no) {
                        $indikators = Indikator::where('aspek_id', $this->edit_aspek_id)
                            ->where('sub_id', null)
                            ->where('no', '>', $current_indikator->no)
                            ->where('no', '<=', $targetNo)
                            ->orderBy('no')
                            ->get()
                            ->each(function ($indikator) {
                                $indikator->no -= 1;
                                $indikator->save();
                            });
                    } else {
                        $indikators = Indikator::where('aspek_id', $this->edit_aspek_id)
                            ->where('sub_id', null)
                            ->where('no', '<', $current_indikator->no)
                            ->where('no', '>=', $targetNo)
                            ->orderBy('no')
                            ->get()
                            ->each(function ($indikator) {
                                $indikator->no += 1;
                                $indikator->save();
                            });
                    }
                    $current_indikator->no = $targetNo;
                    $current_indikator->aspek_id = $this->edit_aspek_id;
                    $current_indikator->sub_aspek_id = $this->edit_sub_aspek_id;
                }


                session()->flash('success', 'Indikator berhasil dipindahkan.');
            } else {
                // dd($this->edit_indikator_id);
                $sub_indikator = Indikator::findOrFail($this->edit_indikator_id);
                $current_indikator->sub_id = $sub_indikator->id;
                $current_indikator->aspek_id = $sub_indikator->aspek_id;
            }
        }

        $current_indikator->content = $this->edit_indikator_content;

        $option = OpsiIndikator::where('indikator_id', $this->ind_id)->get();
        $option->firstWhere('option', 'a')->konten = $this->indikator_a;
        $option->firstWhere('option', 'b')->konten = $this->indikator_b;
        $option->firstWhere('option', 'c')->konten = $this->indikator_c;
        $option->firstWhere('option', 'd')->konten = $this->indikator_d;
        $option->firstWhere('option', 'e')->konten = $this->indikator_e;

        $option->each(function ($opsi) {
            $opsi->save();
        });
        $current_indikator->save();

        $this->toggleModal("none", true);
        $this->is_processing = false;
        $this->reset('modal');
        // $this->dispatch('refresh-page');
        //refresh page
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->aspekId = null;
    }

    public function toggleMultiSoal()
    {
        $this->indikator_multi = !$this->indikator_multi;
    }

    public function delete_indikator()
    {
        $selected_indikator = Indikator::findOrFail($this->ind_id);
        if ($selected_indikator->sub_id != null) {
            $selected_indikator->delete();
            $this->toggleModal('delete-indikator', true);
            return;
        }
        $selected_indikator->delete();
        $all_indikator = Indikator::where('aspek_id', $this->aspek_id)
            ->where('aspek_id', $selected_indikator->aspek_id)
            ->where('no', '>', $selected_indikator->no)
            ->get()
            ->each(function ($indikator) {
                $indikator->no -= 1;
                $indikator->save();
            });
        $this->toggleModal('delete-indikator', true);
    }

    public function render()
    {
        $this->aspek = AspekModel::findOrFail($this->aspek_id);
        // dd($aspek_id);
        $this->sub_aspeks = SubAspekModel::where('aspek_id', $this->aspek_id)->orderBy('no')->get();

        $this->indikator = Indikator::where("aspek_id", $this->aspek_id)
            ->orderBy('no')
            ->get();
        $this->indikator_option = OpsiIndikator::all();
        $get_score = OpsiIndikator::where('choosen', true)->get();
        $get_score = $get_score->filter(function ($opsi) {
            return $opsi->indikator->aspek_id == $this->aspek_id;
        });

        if (count($get_score) != 0) {
            $this->total_skor = $get_score->sum('score') / count($get_score);
        }
        return view('livewire.akreditasi.sub-aspek');
    }

    public function delete_sub_aspek()
    {
        if ($this->confirm_delete_sub == $this->delete_sub->name) {
            $this->delete_sub->delete();
            $this->delete_sub = null;
            $this->toggleModal('delete-sub-aspek', true);
        }

    }

    public function subAspekForm()
    {
        $this->validate([
            'sub_aspek_name' => 'required|string|max:255',
        ]);

        $existingNumbers = SubAspekModel::where(["aspek_id" => $this->aspek_id])->orderBy('no')->pluck('no')->toArray();

        // Cari nomor terbesar tanpa terputus
        $maxContinuous = 0;
        foreach ($existingNumbers as $index => $number) {
            if ($number == $index + 1) {
                $maxContinuous = $number;
            } else {
                // Putus, berhenti
                break;
            }
        }
        if ($this->sub_edit != null) {
            $curr_asp = SubAspekModel::findOrFail($this->sub_edit->id);
            logger($curr_asp);
            $curr_asp->name = $this->sub_aspek_name;
            $curr_asp->save();
        } else {
            SubAspekModel::create([
                "name" => $this->sub_aspek_name,
                "aspek_id" => $this->aspek_id,
                "no" => $maxContinuous + 1,
                "id" => Str::uuid()
            ]);
        }

        $this->sub_aspek_name = "";
        $this->sub_aspek_id = null;
        $this->toggleModal('tambah-sub-aspek', true);
    }

    public function changeDirection($sa_id, $var)
    {
        $aspek = SubAspekModel::findOrFail($sa_id);
        $aspekOther = SubAspekModel::where([
            'no' => $aspek->no - $var,
            'aspek_id' => $this->aspek_id,
        ])->first();

        // Simpan dulu nomor aspek awal
        $originalNo = $aspek->no;

        // Tukar nomor
        $aspek->no = $aspekOther->no;
        $aspekOther->no = $originalNo;

        // Simpan perubahan
        $aspek->save();
        $aspekOther->save();
    }


    public function handleTrixChange()
    {
        // This will be called whenever the content changes
        // You can access the content via $this->indikator_konten
        logger()->info('Trix content changed:', ['content' => $this->indikator_konten]);
    }


    public function submit_indikator()
    {


        $maxContinuous = Indikator::where([
            'aspek_id' => $this->aspek_id,
            'sub_id' => $this->ind_id,
        ])->max('no');



        // dd([$maxContinuous, $this->aspek_id]);

        if (!$this->indikator_multi) {

            logger('indikator_konten: ' . $this->indikator_konten);
            logger('indikator_a: ' . $this->indikator_a);
            logger('indikator_b: ' . $this->indikator_b);
            logger('indikator_c: ' . $this->indikator_c);
            logger('indikator_d: ' . $this->indikator_d);
            logger('indikator_e: ' . $this->indikator_e);
            $ind_id = Str::uuid();
            $this->validate([
                'indikator_konten' => 'required',
                'indikator_a' => 'required|string|max:255',
                'indikator_b' => 'required|string|max:255',
                'indikator_c' => 'required|string|max:255',
                'indikator_d' => 'required|string|max:255',
                'indikator_e' => 'required|string|max:255',
            ]);




            Indikator::create([
                "id" => $ind_id,
                "content" => $this->indikator_konten,
                "aspek_id" => $this->aspek_id,
                "sub_aspek_id" => null,
                "multiple" => false,
                "sub_id" => $this->ind_id,
                "no" => $maxContinuous + 1,
            ]);

            OpsiIndikator::create([
                "id" => Str::uuid(),
                "indikator_id" => $ind_id,
                "konten" => $this->indikator_a,
                "option" => "a"
            ]);
            OpsiIndikator::create([
                "id" => Str::uuid(),
                "indikator_id" => $ind_id,
                "konten" => $this->indikator_b,
                "option" => "b"
            ]);
            OpsiIndikator::create([
                "id" => Str::uuid(),
                "indikator_id" => $ind_id,
                "konten" => $this->indikator_c,
                "option" => "c"
            ]);
            OpsiIndikator::create([
                "id" => Str::uuid(),
                "indikator_id" => $ind_id,
                "konten" => $this->indikator_d,
                "option" => "d"
            ]);
            OpsiIndikator::create([
                "id" => Str::uuid(),
                "indikator_id" => $ind_id,
                "konten" => $this->indikator_e,
                "option" => "e"
            ]);
        } else {
            /* 
            Memiliki kebijakan tertulis pengembangan koleksi dan disahkan oleh pihak berwenang, yang memuat:
            Kriteria seleksi bahan perpustakaan
            Jenis dan jumlah koleksi yang harus dimiliki
            Kebijakan penambahan koleksi
            Metode perolehan dan peruntukan koleksi
            Evaluasi koleksi dan penyiangan
            Sistem pemeliharaan dan pengendalian koleksi
            Aspek lain terkait
            */

            $this->validate([
                'indikator_konten' => 'required|max:255',
                'indikator_a' => 'nullable|string|max:255',
                'indikator_b' => 'nullable|string|max:255',
                'indikator_c' => 'nullable|string|max:255',
                'indikator_d' => 'nullable|string|max:255',
                'indikator_e' => 'nullable|string|max:255',
            ]);

            // dd([
            //     'indikator_konten' => $this->indikator_konten,
            //     'indikator_a' => $this->indikator_a,
            //     'indikator_b' => $this->indikator_b,
            //     'indikator_c' => $this->indikator_c,
            //     'indikator_d' => $this->indikator_d,
            //     'indikator_e' => $this->indikator_e,
            // ]);

            // Jumlah koleksi buku tercetak (termasuk koleksi referensi), pilih pernyataan berikut:

            $ind_id = Str::uuid();
            Indikator::create([
                "id" => $ind_id,
                "content" => $this->indikator_konten,
                "aspek_id" => $this->aspek_id,
                "sub_aspek_id" => null,
                "multiple" => true,
                "sub_id" => null,
                "no" => $maxContinuous + 1,
            ]);
        }

        $this->indikator_konten = null;
        $this->indikator_a = null;
        $this->indikator_b = null;
        $this->indikator_c = null;
        $this->indikator_d = null;
        $this->indikator_e = null;
        $this->ind_id = null;
        $this->indikator_sub = null;
        $this->indikator_multi = false;
        $this->toggleModal('tambah-indikator', true);
    }

    public function setScore($id)
    {

        // dd($id);
        $option = OpsiIndikator::findOrFail($id);
        $mapping = [
            'a' => 5,
            'b' => 4,
            'c' => 3,
            'd' => 2,
            'e' => 1,
        ];

        $nilai = strtolower($option->option); // pastikan lowercase
        $angka = $mapping[$nilai] ?? null; // null jika tidak cocok

        // dd("test");
        // hubungkan OpsiIndikator ke Komponen
        // OpsiIndikator->indikator_id, Indikator->aspek_id, Aspek->komponen_id
        $indikator = $option->indikator; // relasi indikator di model OpsiIndikator

        $all_options = OpsiIndikator::where('indikator_id', $indikator->id)->get()
            ->each(function ($opsi) {
                $opsi->score = 0;
                $opsi->choosen = false;
                $opsi->save();
            });
        ;

        // Ambil aspek dari indikator
        $aspek = $indikator ? $indikator->aspek : null; // relasi aspek di model Indikator

        // Ambil komponen dari aspek
        $komponen = $aspek ? $aspek->komponen : null; // relasi komponen di model Aspek

        $score = ($komponen->skor / 5) * $angka;
        $option->score = $score;
        $option->choosen = true;
        $option->save();

        $get_score = OpsiIndikator::where('choosen', true)->get();
        $get_score = $get_score->filter(function ($opsi) {
            return $opsi->indikator->aspek_id == $this->aspek_id;
        });

        $this->total_skor = 123;
    }

}
