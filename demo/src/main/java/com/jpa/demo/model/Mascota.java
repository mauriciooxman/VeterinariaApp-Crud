package com.jpa.demo.model;


import com.fasterxml.jackson.annotation.JsonIgnoreProperties;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.JoinColumn;
import jakarta.persistence.JoinTable;
import jakarta.persistence.ManyToOne;
import jakarta.persistence.ManyToMany;

import java.util.List;


@Entity
public class Mascota {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    private String nombre;
    private String raza;
    private String tipoDeAnimal;

    @ManyToOne
    @JoinColumn(name = "duenio_id")
    @JsonIgnoreProperties("mascotas")
    private Usuario duenio;

    @ManyToOne
    @JoinColumn(name = "veterinario_id")
    @JsonIgnoreProperties("mascotas")
    private Veterinario veterinario;

        @ManyToMany
        @JoinTable(
            name = "mascota_medicamentos",
            joinColumns = @JoinColumn(name = "mascota_id"),
            inverseJoinColumns = @JoinColumn(name = "medicamento_id")
        )
        private List<Medicamento> medicamentos;

    public Mascota() {
    }

    public Mascota(Long id, String raza, String nombre, String tipoDeAnimal, Usuario duenio, Veterinario veterinario, List<Medicamento> medicamentos) {
        this.id = id;
        this.raza = raza;
        this.nombre = nombre;
        this.tipoDeAnimal = tipoDeAnimal;
        this.duenio = duenio;
        this.veterinario = veterinario;
        this.medicamentos = medicamentos;
    }

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public String getNombre() {
        return nombre;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public String getRaza() {
        return raza;
    }

    public void setRaza(String raza) {
        this.raza = raza;
    }

    public String getTipoDeAnimal() {
        return tipoDeAnimal;
    }

    public void setTipoDeAnimal(String tipoDeAnimal) {
        this.tipoDeAnimal = tipoDeAnimal;
    }

    public Usuario getDuenio() {
        return duenio;
    }

    public void setDuenio(Usuario duenio) {
        this.duenio = duenio;
    }

    public Veterinario getVeterinario() {
        return veterinario;
    }

    public void setVeterinario(Veterinario veterinario) {
        this.veterinario = veterinario;
    }

    public List<Medicamento> getMedicamentos() {
        return medicamentos;
    }

    public void setMedicamentos(List<Medicamento> medicamentos) {
        this.medicamentos = medicamentos;
    }
}
