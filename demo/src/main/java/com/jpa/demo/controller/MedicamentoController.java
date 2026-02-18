package com.jpa.demo.controller;

import com.jpa.demo.model.Medicamento;
import com.jpa.demo.service.MedicamentoService;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/medicamentos")
@CrossOrigin(origins = "*")
public class MedicamentoController {
    public final MedicamentoService medicamentoService;

    public MedicamentoController(MedicamentoService medicamentoService) {
        this.medicamentoService = medicamentoService;
    }

    @GetMapping
    public List<Medicamento> getMedicamentos() {
        return medicamentoService.getMedicamento();
    }

    @GetMapping("/{id}")
    public Medicamento traerMedicamentoPorId(@PathVariable Long id) {
        return medicamentoService.findMedicamento(id);
    }

    @PostMapping
    public void saveMedicamento(@RequestBody Medicamento medicamento) {
        medicamentoService.saveMedicamento(medicamento);
    }

    @DeleteMapping("/{id}")
    public void deleteMedicamento(@PathVariable Long id) {
        medicamentoService.deleteMedicamento(id);
    }

    @PutMapping("/editar")
    public Medicamento editMedicamento(@RequestBody Medicamento medicamento) {
        medicamentoService.editMedicamento(medicamento);
        return medicamentoService.findMedicamento(medicamento.getId());
    }
}
