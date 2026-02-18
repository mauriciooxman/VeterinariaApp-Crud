package com.jpa.demo.service;

import com.jpa.demo.model.Medicamento;
import com.jpa.demo.repository.IMedicamento;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class MedicamentoService implements IMedicamentoService {

    public final IMedicamento iMedicamentoRepository;

    public MedicamentoService(IMedicamento iMedicamentoRepository) {
        this.iMedicamentoRepository = iMedicamentoRepository;
    }

    @Override
    public List<Medicamento> getMedicamento() {
        List<Medicamento> listasMedicamento = iMedicamentoRepository.findAll();
        return listasMedicamento;
    }

    @Override
    public void saveMedicamento(Medicamento medicamento) {
        iMedicamentoRepository.save(medicamento);
    }

    @Override
    public Medicamento findMedicamento(Long id) {
        Medicamento medicamento = iMedicamentoRepository.findById(id).orElse(null);
        return medicamento;

    }

    @Override
    public void deleteMedicamento(Long id) {
        iMedicamentoRepository.deleteById(id);
    }

    @Override
    public Medicamento editMedicamento(Medicamento medicamento) {
        this.saveMedicamento(medicamento); // si existe id edita, si no existe id inserta
        return medicamento;
    }
}
