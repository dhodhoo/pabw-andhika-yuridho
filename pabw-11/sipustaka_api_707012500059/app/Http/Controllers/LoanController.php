<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    // GET /api/loans - wajib login
    public function index(Request $request): JsonResponse
    {
        return response()->json(Loan::with('book')->get(), 200);
    }

    // POST /api/loans - wajib login
    public function store(StoreLoanRequest $request): JsonResponse
    {
        $data = $request->validated();

        // user_id otomatis diisi dari pengguna yang sedang login
        $loan = $request->user()->loans()->create($data);

        return response()->json($loan->load('book'), 201);
    }

    // GET /api/loans/{id} - wajib login
    public function show(Request $request, $id): JsonResponse
    {
        return response()->json($this->findOwnedLoan($request, $id)->load('book'), 200);
    }

    // PATCH /api/loans/{id} - wajib login, hanya pemilik
    public function update(UpdateLoanRequest $request, $id): JsonResponse
    {
        $loan = $this->findOwnedLoan($request, $id);
        $loan->update($request->validated());

        return response()->json($loan->load('book'), 200);
    }

    // DELETE /api/loans/{id} - wajib login, hanya pemilik
    public function destroy(Request $request, $id): JsonResponse
    {
        $this->findOwnedLoan($request, $id)->delete();

        return response()->json(['message' => 'Peminjaman berhasil dihapus'], 200);
    }

    // hanya pemilik peminjaman yang boleh lanjut, selain itu 403
    private function findOwnedLoan(Request $request, $id): Loan
    {
        $loan = Loan::find($id);

        if (! $loan) {
            abort(404, 'Peminjaman tidak ditemukan');
        }

        if ($loan->user_id != $request->user()->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah peminjaman ini');
        }

        return $loan;
    }
}
