import { Link } from '@inertiajs/react';
import type { FormEvent } from 'react';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

export type BukuFormData = {
    judul: string;
    penulis: string;
    penerbit: string;
    tahun_terbit: string;
    stok: string;
};

type BukuFormProps = {
    data: BukuFormData;
    errors: Partial<Record<keyof BukuFormData, string>>;
    processing: boolean;
    submitLabel: string;
    setData: (key: keyof BukuFormData, value: string) => void;
    onSubmit: (event: FormEvent) => void;
};

export function BukuForm({
    data,
    errors,
    processing,
    submitLabel,
    setData,
    onSubmit,
}: BukuFormProps) {
    return (
        <form
            onSubmit={onSubmit}
            noValidate
            className="max-w-xl space-y-5 rounded-xl border p-6"
        >
            <div className="grid gap-2">
                <Label htmlFor="judul">
                    Judul <span className="text-red-500">*</span>
                </Label>
                <Input
                    id="judul"
                    value={data.judul}
                    onChange={(event) => setData('judul', event.target.value)}
                    autoFocus
                />
                <InputError message={errors.judul} />
            </div>

            <div className="grid gap-2">
                <Label htmlFor="penulis">
                    Penulis <span className="text-red-500">*</span>
                </Label>
                <Input
                    id="penulis"
                    value={data.penulis}
                    onChange={(event) => setData('penulis', event.target.value)}
                />
                <InputError message={errors.penulis} />
            </div>

            <div className="grid gap-2">
                <Label htmlFor="penerbit">
                    Penerbit <span className="text-red-500">*</span>
                </Label>
                <Input
                    id="penerbit"
                    value={data.penerbit}
                    onChange={(event) => setData('penerbit', event.target.value)}
                />
                <InputError message={errors.penerbit} />
            </div>

            <div className="grid gap-2">
                <Label htmlFor="tahun_terbit">
                    Tahun Terbit <span className="text-red-500">*</span>
                </Label>
                <Input
                    id="tahun_terbit"
                    type="number"
                    value={data.tahun_terbit}
                    onChange={(event) =>
                        setData('tahun_terbit', event.target.value)
                    }
                />
                <InputError message={errors.tahun_terbit} />
            </div>

            <div className="grid gap-2">
                <Label htmlFor="stok">
                    Stok <span className="text-red-500">*</span>
                </Label>
                <Input
                    id="stok"
                    type="number"
                    value={data.stok}
                    onChange={(event) => setData('stok', event.target.value)}
                />
                <InputError message={errors.stok} />
            </div>

            <div className="flex gap-2">
                <Button type="submit" disabled={processing}>
                    {processing ? 'Menyimpan...' : submitLabel}
                </Button>
                <Button asChild variant="secondary">
                    <Link href="/buku">Batal</Link>
                </Button>
            </div>
        </form>
    );
}
