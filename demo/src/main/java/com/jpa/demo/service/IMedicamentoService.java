package com.jpa.demo.service;

import com.jpa.demo.model.Medicamento;

import java.util.List;

public interface IMedicamentoService {
    public List<Medicamento> getMedicamento();

    public void saveMedicamento(Medicamento medicamento);

    public Medicamento findMedicamento(Long id);

    public void deleteMedicamento(Long id);

    public Medicamento editMedicamento(Medicamento medicamento);

}
