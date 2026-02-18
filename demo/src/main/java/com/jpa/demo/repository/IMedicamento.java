package com.jpa.demo.repository;

import com.jpa.demo.model.Medicamento;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface IMedicamento extends JpaRepository<Medicamento, Long> {
}
